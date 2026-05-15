<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\AdminNotification;
use App\Models\Advertisement;
use App\Models\Chat;
use App\Models\Frontend;
use App\Models\Language;
use App\Models\Message;
use App\Models\Software;
use App\Models\Subscriber;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use App\Models\WorkFile;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;


class SiteController extends Controller
{
    public function index(Request $request)
    {
        if (isset($_GET['reference'])) {
            $reference = $_GET['reference'];
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $type      = gs('default_service') ?? "service";
        $featured  = "true";

        return view('Template::home', compact('pageTitle', 'featured', 'type'));
    }

    public function pusher(Request $request)
    {
        $general = gs();

        // Validate request parameters
        $request->validate([
            'socket_id' => 'required|string',
            'channel_name' => 'required|string',
        ]);

        $pusherSecret = $general->pusher_config->app_secret_key;
        $socketId = $request->input('socket_id');
        $channelName = $request->input('channel_name');

        // Create the authentication string
        $str = $socketId . ':' . $channelName;
        $hash = hash_hmac('sha256', $str, $pusherSecret);

        return response()->json([
            'success' => true,
            'message' => "Pusher authentication successful",
            'auth'    => $general->pusher_config->app_key . ':' . $hash,
        ]);
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        $user      = auth()->user();
        return view('Template::contact', compact('pageTitle', 'user'));
    }

    public function contactSubmit(Request $request)
    {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required',
            'subject' => 'required|string|max:255',
            'message' => 'required',
        ]);

        $request->session()->regenerateToken();

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }

        $random = getNumber();

        $ticket           = new SupportTicket();
        $ticket->user_id  = auth()->id() ?? 0;
        $ticket->name     = $request->name;
        $ticket->email    = $request->email;
        $ticket->priority = Status::PRIORITY_MEDIUM;


        $ticket->ticket     = $random;
        $ticket->subject    = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status     = Status::TICKET_OPEN;
        $ticket->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = auth()->user() ? auth()->user()->id : 0;
        $adminNotification->title     = 'A new contact message has been submitted';
        $adminNotification->click_url = urlPath('admin.ticket.view', $ticket->id);
        $adminNotification->save();

        $message                    = new SupportMessage();
        $message->support_ticket_id = $ticket->id;
        $message->message           = $request->message;
        $message->save();

        $notify[] = ['success', 'Ticket created successfully!'];

        return to_route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function policyPages($slug)
    {
        $policy = Frontend::where('tempname', activeTemplateName())->where('slug', $slug)->where('data_keys', 'policy_pages.element')->firstOrFail();
        $pageTitle   = $policy->data_values->title;
        $seoContents = $policy->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('policy_pages', $seoContents->image, getFileSize('seo'), true) : null;
        return view('Template::policy', compact('policy', 'pageTitle', 'seoContents', 'seoImage'));
    }

    public function changeLanguage($lang = null)
    {
        $language          = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return back();
    }

    public function blogs()
    {
        $blogs     = Frontend::where('data_keys', 'blog.element')->where('tempname', activeTemplateName())->paginate(getPaginate());
        $pageTitle = "Blogs";
        return view('Template::blogs', compact('blogs', 'pageTitle'));
    }


    public function blogDetails($slug)
    {
        $blog        = Frontend::where('slug', $slug)->where('data_keys', 'blog.element')->firstOrFail();

        // Fetch the latest blogs (you can adjust the number of blogs you want to fetch, e.g., latest 5)
        $latestBlogs = Frontend::where('data_keys', 'blog.element')
            ->where('slug', '!=', $slug)
            ->latest()
            ->limit(5)
            ->get();

        $pageTitle   = 'Blog Details';
        $seoContents = $blog->seo_content;
        $seoImage    = @$seoContents->image ? frontendImage('blog', $seoContents->image, getFileSize('seo'), true) : null;

        return view('Template::blog_details', compact('blog', 'pageTitle', 'seoContents', 'seoImage', 'latestBlogs'));
    }


    public function cookieAccept()
    {
        Cookie::queue('gdpr_cookie', gs('site_name'), 43200);
    }

    public function cookiePolicy()
    {
        $cookieContent = Frontend::where('data_keys', 'cookie.data')->first();
        abort_if($cookieContent->data_values->status != Status::ENABLE, 404);
        $pageTitle = 'Cookie Policy';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->first();
        return view('Template::cookie', compact('pageTitle', 'cookie'));
    }

    public function placeholderImage($size = null)
    {
        $imgWidth  = explode('x', $size)[0];
        $imgHeight = explode('x', $size)[1];
        $text      = $imgWidth . '×' . $imgHeight;
        $fontFile  = realpath('assets/font/solaimanLipi_bold.ttf');
        $fontSize  = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if ($imgHeight < 100 && $fontSize > 30) {
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bgFill);
        $textBox    = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function maintenance()
    {
        $pageTitle = 'Maintenance Mode';
        if (gs('maintenance_mode') == Status::DISABLE) {
            return to_route('home');
        }
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->first();
        return view('Template::maintenance', compact('pageTitle', 'maintenance'));
    }

    public function fileDownload($fileName, $type)
    {
        try {
            $fileName = decrypt($fileName);
        } catch (Exception $ex) {
            $notify[] = ['error', "Invalid URL."];
            return back()->withNotify($notify);
        }
        if ($type == 'file') {
            $file     = Software::where('software_file', $fileName)->firstOrFail();
            $filePath = getFilePath('softwareFile') . '/' . $file->software_file;
        } elseif ($type == 'documentation') {
            $file     = Software::where('document_file', $fileName)->firstOrFail();
            $filePath = getFilePath('documentFile') . '/' . $file->document_file;
        } elseif ($type == 'workFile') {
            $file     = WorkFile::where('file', $fileName)->firstOrFail();
            $filePath = getFilePath('workFile') . '/' . $file->file;
        } elseif ($type == 'chatFile') {
            $file     = Chat::where('file', $fileName)->firstOrFail();
            $filePath = getFilePath('chatFile') . '/' . $file->file;
        } elseif ($type == 'messageFile') {
            $file     = Message::where('file', $fileName)->firstOrFail();
            $filePath = getFilePath('messageFile') . '/' . $file->file;
        } else {
            $notify[] = ['error', 'Invalid file download request'];
            return back()->withNotify($notify);
        }

        if (!file_exists($filePath)) {
            $notify[] = ['error', "File dose not exists"];
            return back()->withNotify($notify);
        }
        return response()->download($filePath);
    }

    public function adRedirect($id)
    {
        $id         = decrypt($id);
        $ad         = Advertisement::findOrFail($id);
        $ad->click += 1;
        $ad->save();

        if ($ad->type == 'image') {
            return redirect($ad->redirect_url);
        }
        return back();
    }


    public function subscriberStore(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers',
        ]);

        if ($validate->fails()) {
            return response()->json(['error' => $validate->errors()->all()]);
        }

        $subscriber        = new Subscriber();
        $subscriber->email = $request->email;
        $subscriber->save();

        return response()->json(['success' => 'Subscribed successfully!']);
    }
}

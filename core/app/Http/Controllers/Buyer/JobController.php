<?php

namespace App\Http\Controllers\Buyer;

use App\Models\Job;
use App\Models\Chat;
use App\Models\JobBid;
use App\Models\Category;
use App\Models\WorkFile;
use App\Constants\Status;
use App\Models\SubCategory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
        $pageTitle = 'Manage Job';
        $jobs      = Job::searchable(['name', 'category:name'])->where('user_id', auth()->id())->latest()->with('category')->paginate(getPaginate());
        return view('Template::buyer.job.index', compact('pageTitle', 'jobs'));
    }


    public function basic($id = 0)
    {
        $pageTitle  = 'Basic Information';
        $categories = Category::active()->orderBy('name')->with('subcategories', function ($q) {
            $q->active();
        })->get();
        $job = Job::where('id', $id)->where('user_id', auth()->id())->first();

        return view('Template::buyer.job.basic', compact('pageTitle', 'categories', 'job'));
    }

    public function storeBasic(Request $request, $id = 0)
    {
        $validation  = Validator::make($request->all(), [
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|integer|gt:0',
            'sub_category_id' => 'required|integer|gt:0',
            'price'           => 'required|numeric|gt:0',
            'delivery_time'   => 'required|integer|gt:0',
            'description'     => 'required',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }

        $category = Category::active()->where('id', $request->category_id)->first();

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => "Category not found!"
            ]);
        }
        $subcategory = Subcategory::active()->where('id', $request->sub_category_id)->first();
        if (!$subcategory) {
            return response()->json([
                'success' => false,
                'message' => "Subcategory not found!"
            ]);
        }

        if ($id) {
            $this->statusToggle($id);
        }

        $user = auth()->user();

        if ($id) {
            $job = Job::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        } else {
            $job          = new Job();
            $job->step    = 1;
            $job->user_id = $user->id;
        }

        $job->name            = $request->name;
        $job->category_id     = $request->category_id;
        $job->sub_category_id = $request->sub_category_id;
        $job->price           = $request->price;
        $job->delivery_time   = $request->delivery_time;
        $job->description     = $request->description;
        $job->save();

        return response()->json([
            'success' => true,
            'redirect_url' => route('user.buyer.job.gallery', $job->id)
        ]);
    }

    public function gallery($id)
    {
        $pageTitle    = 'Job Gallery';
        $job = Job::where('id', $id)->where('user_id', auth()->id())->first();
        if ($job->step < 1) {
            return abort(404);
        }
        return view('Template::buyer.job.gallery', compact('pageTitle', 'job'));
    }


    public function storeGallery(Request $request, $id)
    {
        $job = Job::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => "Software not found"
            ]);
        }
        $isRequired = $job->image ? 'nullable' : 'required';
        $validation = Validator::make($request->all(), [
            'image'   => [$isRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }
        $this->statusToggle($id);

        $isUpdate = true;
        if (!$job->image) {
            $job->step = 2;
            $isUpdate = false;
        }
        if ($request->hasFile('image')) {
            $job->image   = fileUploader($request->image, getFilePath('job'), getFileSize('job'), @$job->image);
        }
        $job->save();

        return response()->json([
            'success' => true,
            'is_update' => $isUpdate,
            'redirect_url' => route('user.buyer.job.skill', $job->id)
        ]);
    }

    public function skill($id)
    {
        $pageTitle  = 'Job Skill';
        $job = Job::where('id', $id)->where('user_id', auth()->id())->first();
        if ($job->step < 2) {
            return abort(404);
        }
        return view('Template::buyer.job.skill', compact('pageTitle', 'job'));
    }

    public function storeSkill(Request $request, $id)
    {
        $validation  = Validator::make($request->all(), [
            'skill'           => 'required|array|min:3|max:15',
            'skill.*'         => 'nullable|string'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }
        $job = Job::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => "Service not found!"
            ]);
        }

        $this->statusToggle($id);

        $isUpdate = true;
        if (!$job->skill) {
            $job->step  = 3;
            $isUpdate = false;
        }
        $job->skill  = $request->skill;
        $job->save();

        return response()->json([
            'success'      => true,
            'is_update'    => $isUpdate,
            'redirect_url' =>  route('user.buyer.job.requirement', $job->id)
        ]);
    }


    public function requirement($id)
    {
        $pageTitle  = 'Job Requirement';
        $job = Job::where('id', $id)->where('user_id', auth()->id())->first();
        if ($job->step < 3) {
            return abort(404);
        }
        return view('Template::buyer.job.requirement', compact('pageTitle', 'job'));
    }


    public function storeRequirement(Request $request, $id)
    {
        $validation  = Validator::make($request->all(), [
            'requirements'    => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->all()
            ]);
        }
        $job = Job::where('id', $id)->where('user_id', auth()->id())->first();
        if (!$job) {
            return response()->json([
                'success' => false,
                'message' => "Software not found!"
            ]);
        }

        $isUpdate = true;
        if (!$job->requirements) {
            $job->step  = 4;
            $isUpdate = false;
        }



        $this->statusToggle($id);


        $job->requirements     = $request->requirements;
        $job->save();

        return response()->json([
            'success'      => true,
            'is_update'    => $isUpdate,
            'redirect_url' =>  route('user.buyer.job.index')
        ]);
    }

    protected function statusToggle($id)
    {
        $job = Job::where('id', $id)->where('user_id', auth()->id())->first();


        if (gs()->post_approval) {
            $job->status = Status::APPROVED;
        } else {
            $job->status = Status::PENDING;
        }

        $job->save();
    }

    public function close($id)
    {
        $job             = Job::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $job->status     = Status::CLOSED;
        $job->updated_at = now();
        $job->save();

        $notify[] = ['success', 'Job is closed successfully'];
        return back()->withNotify($notify);
    }

    public function biddingList(Request $request, $slug, $id)
    {
        $pageTitle = 'Job Bidding List';

        // Get the job associated with the authenticated user
        $job = Job::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        // Start query for bidding list
        $biddingList = JobBid::where('job_id', $job->id)
            ->where('buyer_id', auth()->id())
            ->where('status', '!=', Status::APPROVED)
            ->with('user');

        // Apply search filter (Job Name / Recruiter / Bidder)
        if ($request->filled('search')) {
            $biddingList->searchable([
                'job:name',
                'user:username,email',
            ]);
        }

        // Apply Status Filter
        if ($request->filled('status')) {
            $biddingList->where('status', $request->status);
        }

        // Apply Working Status Filter
        if ($request->filled('working_status')) {
            $biddingList->where('working_status', $request->working_status);
        }

        // Paginate results
        $biddingList = $biddingList->latest()->paginate(getPaginate());

        return view('Template::user.job.job_hiring', compact('pageTitle', 'biddingList'));
    }


    public function bidApprove($id)
    {
        $user = auth()->user();
        $bid  = JobBid::where('id', $id)->where('buyer_id', $user->id)->where('status', Status::PENDING)->firstOrFail();

        if ($bid->price > $user->balance) {
            $notify[] = ['error', 'You don\'t have enough balance to hire this bidder'];
            return back()->withNotify($notify);
        }

        $user->balance -= $bid->price;
        $user->save();

        $bid->status         = Status::APPROVED;
        $bid->working_status = Status::WORKING_INPROGRESS;
        $bid->updated_at     = now();
        $bid->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $bid->price;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '-';
        $transaction->details      = 'Payment for hiring a bidder for a job';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'job_hiring';
        $transaction->save();

        notify($bid->user, 'EMPLOYEE_HIRED', [
            'buyer_username' => $user->username,
            'job_name'       => $bid->job->name,
            'budget'         => showAmount($bid->price, currencyFormat: false),
            'delivery_time'  => showDateTime($bid->created_at->addDays($bid->job->delivery_time), ('M, d - Y'))
        ]);

        $notify[] = ['success', 'This bid is approved successfully'];
        return back()->withNotify($notify);
    }

    public function bidCancel($id)
    {
        $bid                 = JobBid::where('id', $id)->where('buyer_id', auth()->id())->where('status', Status::PENDING)->firstOrFail();
        $bid->status         = Status::CANCELED;
        $bid->working_status = null;
        $bid->updated_at     = now();
        $bid->save();

        notify($bid->user, 'BID_CANCELED', [
            'buyer_username' => auth()->user()->username,
            'job_name'       => $bid->job->name,
            'budget'         => showAmount($bid->price, currencyFormat: false)
        ]);

        $notify[] = ['success', 'This bid is canceled successfully'];
        return back()->withNotify($notify);
    }

    public function hiringList()
    {
        $pageTitle  = 'Hiring List';
        $biddingList = JobBid::where('buyer_id', auth()->id())->where('status', Status::APPROVED)->latest()->with('user')->paginate(getPaginate());

        return view('Template::user.job.job_hiring', compact('pageTitle', 'biddingList'));
    }

    public function hiringDetails($id)
    {
        $pageTitle = 'Hiring Details';
        $details = JobBid::where('id', $id)->where('buyer_id', auth()->id())->with(['job', 'disputer'])->firstOrFail();
        $workFiles = WorkFile::where('job_bid_id', $details->id)->latest()->with(['sender', 'receiver'])->paginate(getPaginate());

        if (request()->ajax()) {
            $lastChatId = request('last_chat_id');
            $chatsQuery = Chat::where('job_bid_id', $details->id)->with('user')->latest();

            if ($lastChatId) {
                $chatsQuery->where('id', '<', $lastChatId);
            }

            $chats = $chatsQuery->latest()->take(10)->get();

            if ($chats->isEmpty()) {
                return response()->json(['last' => true]);
            }

            $view = view('Template::partials.chat_messages', compact('chats', 'details'))->render();

            return response()->json([
                'success' => true,
                'html' => $view,
            ]);
        }

        $chats = Chat::where('job_bid_id', $details->id)->with('user')->latest()->take(10)->get();
        $lastChatId = $chats->last()->id ?? null;

        return view('Template::user.job.details', compact('pageTitle', 'details', 'workFiles', 'chats', 'lastChatId'));
    }


    public function hiringCompleted(Request $request, $id)
    {
        $bid =  JobBid::where('id', $id)->where('buyer_id', auth()->id())->where('status', Status::APPROVED)->where(function ($q) {
            $q->where('working_status', Status::WORKING_INPROGRESS)->orWhere('working_status', Status::WORKING_DELIVERED);
        })->with('user')->firstOrFail();

        $bid->working_status = Status::WORKING_COMPLETED;
        $bid->updated_at     = now();
        $bid->save();

        $bid->user->balance += $bid->price;
        $bid->user->earning += $bid->price;
        $bid->user->save();

        userLevel($bid->user);

        $transaction               = new Transaction();
        $transaction->user_id      = $bid->user->id;
        $transaction->amount       = $bid->price;
        $transaction->post_balance = $bid->user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'For completing a job';
        $transaction->trx          = getTrx();
        $transaction->remark       = 'job_delivered';
        $transaction->save();

        notify($bid->user, 'JOB_COMPLETED', [
            'buyer_username' => auth()->user()->username,
            'job_name'      => $bid->job->name,
            'amount'        => showAmount($bid->price, currencyFormat: false),
            'message'       => 'Job has been marked as completed by buyer'
        ]);

        $notify[] = ['success', 'Job marked as completed successfully'];
        return back()->withNotify($notify);
    }

    protected function checkData($request, $id)
    {
        $category    = Category::active();
        $subcategory = SubCategory::active();

        $category = $category->where('id', $request->category_id)->first();

        if (!$category) {
            return ['error', 'Category not found or disabled'];
        } else {
            $subcategory = $subcategory->where('id', $request->sub_category_id)->where('category_id', $category->id)->first();

            if (!$subcategory) {
                return ['error', 'Subcategory not found or disabled'];
            }
        }

        return ['success'];
    }
}

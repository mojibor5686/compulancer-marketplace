<?php

namespace App\Lib;

use Illuminate\Support\Facades\Config;
use App\Events\SendMessageToChat;
use App\Events\InboxChatMessage;
use Illuminate\Http\Request;

class PusherService
{
    public function initializePusher()
    {
        try {
            // Fetch the Pusher configuration from the general settings
            $general = @gs();

            $appKey = $general?->pusher_config?->app_key;
            $appSecret = $general?->pusher_config?->app_secret_key;
            $appId = $general?->pusher_config?->app_id;
            $cluster = $general?->pusher_config?->cluster;

            // Validate configuration
            if (!$appKey || !$appSecret || !$appId || !$cluster) {
                \Log::error('Pusher configuration is missing or invalid.');
                return false;
            }

            // Set the broadcasting configuration
            Config::set('broadcasting.default', 'pusher');
            Config::set('broadcasting.connections.pusher', [
                'driver'  => 'pusher',
                'key'     => $appKey,
                'secret'  => $appSecret,
                'app_id'  => $appId,
                'options' => [
                    'cluster' => $cluster,
                    'useTLS'  => true,
                ],
            ]);

            return true;
        } catch (\Exception $e) {
            // Log the exception for debugging
            \Log::error('Error initializing Pusher: ' . $e->getMessage());
            return false;
        }
    }


    public function sendMessageToChat(Request $request, $data, $user, $receiver, $chat)
    {
        if ($this->initializePusher()) {
            try {
                event(new SendMessageToChat(
                    $request->type . '_' . $data->id,
                    $user,
                    $receiver,
                    $chat->message,
                    $chat->file ? route('file.download', [encrypt($chat->file), 'chatFile']) : null,
                    $data->id,
                    $chat->file ? $chat->file : null,
                ));
            } catch (\Exception $e) {
                // Log the exception for debugging
                \Log::error('Error broadcasting SendMessageToChat event: ' . $e->getMessage());
                return false;
            }
            return true;
        }

        return false;
    }

    public function sendInboxMessage($data)
    {
        if ($this->initializePusher()) {
            try {
                event(new InboxChatMessage($data));
            } catch (\Exception $e) {
                // Log the exception for debugging
                \Log::error('Error broadcasting InboxChatMessage event: ' . $e->getMessage());
                return false;
            }
            return true;
        }

        return false;
    }
}

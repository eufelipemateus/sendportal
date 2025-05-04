<?php

declare(strict_types=1);

namespace App\Http\Controllers\Webview;

use Exception;
use Illuminate\Contracts\View\View as ViewContract;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Services\Content\MergeContentService;

class WebviewController extends Controller
{
    /** @var MergeContentService */
    private $merger;

    public function __construct(MergeContentService $merger)
    {
        $this->merger = $merger;
    }

    /**
     * @throws Exception
     */
    public function show(string $messageHash): ViewContract
    {
        /** @var Message $message */
        $message = Message::with('subscriber')->where('hash', $messageHash)->first();

        $content = $this->merger->handle($message);

        return view('webview.show', compact('content'));
    }
}

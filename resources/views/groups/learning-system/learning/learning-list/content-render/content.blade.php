<div class="card-header">
    <h5 class="card-title">{{$topic->name}}</h5>
</div>
<div class="card-body">
    <div class="row" id="content_wrapper">
        <div class="col-12">{!!$topic->body!!}</div>
        @if (count($topicAttachments) != 0)
        
        <div class="col-12 mt-2">
            
            <h5>ไฟลน์แนบ</h5>
            <ul id="files_wrapper" style="width: 300px">
                @foreach ($topicAttachments as $topicAttachment)
                <li class="file_content" id="attachment-{{$topicAttachment->id}}">
                    <p>{{ $topicAttachment->name }}</p>
                    <a href="{{ route('storage.topic.attachment.download', ['file'=> $topicAttachment->file]) }}" class="btn btn-action p-0" style="width: max-content; font-size: 1rem;"><i class="fas fa-download"></i></a>
                </li>
                {{-- <tr>
                    <td></td>
                    <td class="text-end">
                        <a class="btn btn-primary btn-sm"
                            href="{{url('/storage/uploads/attachment') .'/'. $topicAttachment->file}}">
                            <i class="fas fa-download"></i>
                        </a>
                    </td>
                </tr> --}}
                @endforeach
            </ul>
        </div>
        
        @endif
    </div>
</div>
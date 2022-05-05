<div class="m-accordion m-accordion--section m-accordion--padding-lg mb-5">
    <!--begin::Item-->
    <br>
    <br>
    @foreach($notes as $note)
        <div class="m-accordion__item note-shadow">
            <div class="dropdown mt-4 position-absolute" style="right:8px">
                <button class="note_btns btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air dropdown-toggle" type="button" id="dropdownMenuButton{{$note->note_id}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton{{$note->note_id}}">
                    <a onclick="edit_note({{$note->note_id}})" class="dropdown-item" href="javascript:;" data-toggle="m-tooltip" title="Tooltip title" data-placement="right" data-skin="dark" 	data-container="body">
                        Edit
                    </a>
                    <a onclick="delete_note({{$note->note_id}})" class="dropdown-item" href="javascript:;">
                        Delete
                    </a>
                </div>
            </div>

            <div class="m-accordion__item-head collapsed" role="tab" id="m_section_1_content_2_head{{$note->note_id}}" data-toggle="collapse" href="#m_section_1_content_2_body{{$note->note_id}}">
            <span class="m-accordion__item-title">
                {{$note->title}}
            </span>
                <span class="m-accordion__item-mode mr-3"></span>
            </div>
            <div class="m-accordion__item-body collapse" id="m_section_1_content_2_body{{$note->note_id}}" role="tabpanel" aria-labelledby="m_section_1_content_2_head{{$note->note_id}}" data-parent="#m_section_1_content{{$note->note_id}}">
                <div class="m-accordion__item-content">

                        {!!$note->description!!}

                </div>
            </div>
        </div>
@endforeach
<!--end::Item-->
</div>

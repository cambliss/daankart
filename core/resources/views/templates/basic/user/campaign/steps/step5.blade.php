<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
<style>
    .custom--accordion .accordion-button {
        background-color: hsl(var(--base));
        color: white;
    }
    .custom--accordion .accordion-body {
        background-color: white;
        color: black;
    }
</style>
<form method="POST" action="{{ route('user.campaign.fundrise.save', ['step' => 5, 'id' => $id ?? 0]) }}"
    id="step-content-5" class="step-content {{ $step == 5 ? 'active' : '' }}">
    @csrf
    {{-- Add Collapse card in ForEach with arr and add button to add new card --}}
    <div class="accordion custom--accordion" id="page_json_container">

    </div>
    <input type="hidden" name="page_json" id="page_json_hidden" value="" />
    <div class="row">
        <div class="col-6">
            <button type="submit" class="btn btn-success w-100 mt-3">Submit</button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-success w-100 mt-3" onclick="addSection()">Add Section</button>
        </div>
    </div>
    <div class="d-none">
        <select id="section_type" name="section_type" class="form-control">
            <option value="youtube">Youtube</option>
            <option value="image">Image</option>
            <option value="paragraph">Paragraph</option>
            <option value="video">Video</option>
            <option value="heading">Heading</option>
            <option value="subheading">Subheading</option>
            <option value="image_slider">Image Slider</option>
            <option value="faq">FAQ</option>
        </select>
    </div>
</form>
@push('script')
    <!-- Quill.js CDN -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

    <script>
        @if($campaign)
            let sections = JSON.parse(`{!! $campaign->page_json !!}`);
        @else
            let sections = [{
                    type: "youtube",
                    content: "https://www.youtube.com/embed/dQw4w9WgXcQ"
                },
                {
                    type: "image",
                    content: "https://via.placeholder.com/150"
                }
            ];
        @endif

        var sectionTypeSector = '';

        $(document).ready(function() {
            sectionTypeSector = $('#section_type')[0].outerHTML;
            $('#page_json').val(JSON.stringify($('#page_json_hidden').val()));
            updatePageJson();

            initializeQuillEditors(); // Initialize Quill.js for rich text editing
        });

        function updatePageJson() {
            $('#page_json_container').html('');
            sections.forEach((section, index) => {
                let uuid = new Date().getTime() + index;
                $('#page_json_container').append(getSectionTemplate(section.type, section.content, index, uuid));
                $(`#section-${uuid} select[name="section_type"]`).val(section.type);
                $(`#section-${uuid} [name="section_content"]`).html(section.content);
            });
            initializeQuillEditors(); // Ensure new rich text editors are initialized
            updateSectionData();
        }

        function addSection() {
            let uuid = new Date().getTime();
            $('#page_json_container').append(getSectionTemplate('', '', sections.length, uuid));

            initializeQuillEditors();
        }

        function getSectionTemplate(type = '', content = '', index, uuid) {
            let contentInput = getContentInput(type, content, uuid);

            return `
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#section-${uuid}" type="button" aria-expanded="false">
                        Section ${index + 1}
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="section-${uuid}">
                    <div class="accordion-body">
                        ${sectionTypeSector}
                        <div class="content-container">${contentInput}</div>
                    </div>
                </div>
            </div>
        `;
        }

        function getContentInput(type, content, uuid) {
            if (type === 'youtube') {
                return `
                <input type="url" name="section_content" class="form-control youtube-url"
                       placeholder="Enter a valid YouTube URL" value="${content}" />
            `;
            } else if (type === 'image' || type === 'video') {
                return `<input type="file" name="section_content" class="form-control" accept="${type}/*" />`;
            } else if (type === 'image_slider') {
                return `<input type="file" name="section_content[]" class="form-control" multiple />`;
            } else if (type === 'paragraph' || type === 'heading' || type === 'subheading') {
                return `<div id="editor-${uuid}" class="quill-editor" data-content="${content}"></div>`;
            } else if (type === 'faq') {
                // we have to multiple question and answer object with add & remove button
                return `
                <div class="add-faq-container" >
                    <div id="faq-container">
                        <div class="add-faq-item">
                            <input type="text" name="section_content_question[0]" class="form-control" placeholder="Question" />
                            <textarea type="text" name="section_content_answer[0]" class="form-control" placeholder="Answer" ></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" onclick="addFaq()">Add</button>
                </div>
                `;
            }
            return `<textarea name="section_content" class="form-control">${content}</textarea>`;
        }

        // Handle Section Type Change and Update Content
        $(document).on('change', 'select[name="section_type"]', function() {
            const selectedType = $(this).val();
            const contentContainer = $(this).closest('.accordion-body').find('.content-container');
            const uuid = new Date().getTime();

            contentContainer.html(getContentInput(selectedType, '', uuid));

            if (selectedType === 'paragraph' || selectedType === 'heading' || selectedType === 'subheading') {
                initializeQuillEditors();
            }
        });

        // Initialize Quill.js for Rich Text Editors
        function initializeQuillEditors() {
            $('.quill-editor').each(function() {
                const editorId = $(this).attr('id');

                if (!$(this).hasClass('quill-initialized')) {
                    new Quill(`#${editorId}`, {
                        theme: 'snow',
                        placeholder: 'Start writing here...',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline'],
                                [{
                                    'list': 'ordered'
                                }, {
                                    'list': 'bullet'
                                }],
                                [{
                                    'align': []
                                }],
                                ['link']
                            ]
                        }
                    }).root.innerHTML = $(this).attr('data-content');

                    $(this).addClass('quill-initialized'); // Prevent multiple instances
                }
            });
        }

        function updateSectionData() {
            let collectedData = [];

            $('#page_json_container .accordion-item').each(function() {
                const sectionType = $(this).find('select[name="section_type"]').val();
                const contentContainer = $(this).find('.content-container');

                let sectionContent = '';
                if (sectionType === 'youtube') {
                    sectionContent = contentContainer.find('.youtube-url').val();

                    // Basic YouTube URL Validation
                    const youtubeRegex = /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/;
                    if (!youtubeRegex.test(sectionContent)) {
                        // alert(`Invalid YouTube URL in Section ${$(this).index() + 1}`);
                        return false; // Stop submission if invalid
                    }
                } else if (sectionType === 'image' || sectionType === 'video') {
                    const file = contentContainer.find('input[name="section_content"]')[0].files[0];
                    sectionContent = file ? file.name : '';
                } else if (sectionType === 'image_slider') {
                    const files = contentContainer.find('input[name="section_content[]"]')[0].files;
                    sectionContent = [...files].map(file => file.name);
                } else if (sectionType === 'paragraph') {
                    sectionContent = contentContainer.find('.ql-editor').html(); // Quill content capture
                }

                collectedData.push({
                    type: sectionType,
                    content: sectionContent
                });
            });

            $('#page_json_hidden').val(JSON.stringify(collectedData));
        }

        function addFaq() {
            let length = $('#faq-container').find('.add-faq-item').length;
            // add new faq item
            $('#faq-container').append(getFaqTemplate(length));
        }

        function getFaqTemplate(length) {
            return `
            <div class="add-faq-item">
                <input type="text" name="section_content_question[${length}]" class="form-control" placeholder="Question" />
                <textarea type="text" name="section_content_answer[${length}]" class="form-control" placeholder="Answer" ></textarea>
            </div>
            `;
        }

        // Collect and Save JSON Data
        $('form').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission
            updateSectionData();

            this.submit(); // Submit the form after building the JSON
        });
    </script>
@endpush

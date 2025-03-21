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

    #step-content-5 .content-container img {
        height: 100px;
        width: 100px;
        object-fit: contain;
    }
    
</style>
<form method="POST" action="{{ route('user.campaign.fundrise.save', ['step' => 5, 'id' => $id ?? 0]) }}"
    id="step-content-5" class="step-content {{ $step == 5 ? 'active' : '' }}">
    @csrf
    <div class="accordion custom--accordion" id="page_json_container">
        <!-- Sections will be dynamically added here -->
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
        <select id="section_type" class="form-control">
            <option value="youtube">Youtube</option>
            <option value="image_url">Image URL</option>
            <option value="video_url">Video URL</option>
            <option value="document_url">Document URL</option>
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
        let sections = [];
        let quillEditors = {};
        let sectionTypeSector = '';

        $(document).ready(function() {
            // Initialize with default sections if no existing data
            sections = [{
                type: "youtube",
                content: "https://www.youtube.com/embed/dQw4w9WgXcQ"
            }, {
                type: "image",
                content: "https://via.placeholder.com/150"
            }];

            // Load existing campaign data if available
            @if ($campaign && $campaign->page_json)
                try {
                    const parsedSections = JSON.parse(`{!! $campaign->page_json ?? '[]' !!}`);
                    if (Array.isArray(parsedSections) && parsedSections.length > 0) {
                        sections = parsedSections;
                    }
                } catch (e) {
                    console.error("Error parsing page_json:", e);
                }
            @endif

            // Save section type template and initialize UI
            sectionTypeSector = $('#section_type')[0].outerHTML;
            updatePageJson();
        });

        // Update the UI based on the sections data
        function updatePageJson() {
            $('#page_json_container').html('');

            sections.forEach((section, index) => {
                const uuid = `section_${new Date().getTime()}_${index}`;
                $('#page_json_container').append(getSectionTemplate(section.type, section.content, index, uuid));

                // Set the correct section type in the dropdown
                $(`#${uuid} select`).val(section.type);

                // Initialize content based on type
                if (section.type === 'paragraph' || section.type === 'heading' || section.type === 'subheading') {
                    // Will be handled in initializeQuillEditors
                } else if (section.type === 'faq' && Array.isArray(section.content)) {
                    renderFaqItems(uuid, section.content);
                } else if ((section.type === 'image' || section.type === 'video') && section.content) {
                    $(`#uploaded-file-preview-${uuid}`).html(
                        section.type === 'image' ?
                        `<img src="${section.content}" class="img-fluid" />` :
                        `<video src="${section.content}" class="img-fluid" controls></video>`
                    );
                } else if (section.type === 'image_slider' && Array.isArray(section.content)) {
                    renderImageSlider(uuid, section.content);
                }
            });

            initializeQuillEditors();
            updateSectionData(); // Set initial JSON data
        }

        // Add a new section to the page builder
        function addSection() {
            const uuid = `section_${new Date().getTime()}`;
            sections.push({
                type: "paragraph",
                content: ""
            });

            $('#page_json_container').append(getSectionTemplate("paragraph", "", sections.length - 1, uuid));
            initializeQuillEditors();
            updateSectionData();
        }

        // Generate HTML template for a section
        function getSectionTemplate(type, content, index, uuid) {
            const contentInput = getContentInput(type, content, uuid);

            return `
            <div class="accordion-item" id="${uuid}" data-index="${index}">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                        data-bs-target="#collapse-${uuid}" type="button" aria-expanded="false">
                        Section ${index + 1}: ${type.charAt(0).toUpperCase() + type.slice(1)}
                    </button>
                </h2>
                <div class="accordion-collapse collapse" id="collapse-${uuid}">
                    <div class="accordion-body">
                        <div class="d-flex justify-content-between mb-3">
                            ${sectionTypeSector}
                            <button type="button" class="btn btn-danger" onclick="removeSection('${uuid}')">Remove</button>
                        </div>
                        <div class="content-container" data-section-type="${type}" data-uuid="${uuid}">${contentInput}</div>
                    </div>
                </div>
            </div>
            `;
        }

        // Generate appropriate input fields based on section type
        function getContentInput(type, content, uuid) {
            switch (type) {
                case 'youtube':
                case 'image_url':
                case 'video_url':
                case 'document_url':
                    return `<input type="url" class="form-control section-content" data-type="${type}" placeholder="Enter a valid URL" value="${content || ''}" oninput="updateContentValue('${uuid}', this.value)" />`;

                case 'image':
                case 'video':
                    return `
                        <div class="mb-3">
                            <input type="file" class="form-control" accept="${type}/*" onchange="handleFileSelection('${uuid}', '${type}')" />
                            <input type="hidden" class="section-content" data-type="${type}" value="${content || ''}" />
                        </div>
                        <div id="uploaded-file-preview-${uuid}" class="mt-2">
                            ${content ? (type === 'image' ? `<img src="${content}" class="img-fluid" />` : `<video src="${content}" class="img-fluid" controls></video>`) : ''}
                        </div>
                    `;

                case 'image_slider':
                    return `
                        <div class="mb-3">
                            <input type="file" class="form-control" accept="image/*" multiple onchange="handleMultipleFileSelection('${uuid}')" />
                            <div id="image-slider-container-${uuid}" class="d-flex flex-wrap mt-3">
                                ${Array.isArray(content) ? content.map(img => `<div class="position-relative me-2 mb-2"><img src="${img}" class="img-thumbnail" style="height:100px"/><button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeSliderImage('${uuid}', '${img}')">×</button></div>`).join('') : ''}
                            </div>
                            <input type="hidden" class="section-content" data-type="${type}" value="${Array.isArray(content) ? JSON.stringify(content) : '[]'}" />
                        </div>
                    `;

                case 'paragraph':
                case 'heading':
                case 'subheading':
                    return `<div id="editor-${uuid}" class="quill-editor" data-content="${content || ''}" data-type="${type}"></div>`;

                case 'faq':
                    // Ensure proper initialization of FAQ content
                    let faqItems = [];
                    if (Array.isArray(content)) {
                        faqItems = content;
                    } else if (content && typeof content === 'string') {
                        try {
                            faqItems = JSON.parse(content);
                            if (!Array.isArray(faqItems)) faqItems = [];
                        } catch (e) {
                            faqItems = [];
                        }
                    }

                    return `
                        <div class="faq-container" id="faq-container-${uuid}">
                            ${faqItems.length > 0 ? 
                                faqItems.map((item, idx) => getFaqItemTemplate(uuid, idx, item.question, item.answer)).join('') : 
                                getFaqItemTemplate(uuid, 0, '', '')}
                        </div>
                        <button type="button" class="btn btn-primary mt-2" onclick="addFaqItem('${uuid}')">Add Question</button>
                    `;

                default:
                    return `<textarea class="form-control section-content" data-type="${type}" oninput="updateContentValue('${uuid}', this.value)">${content || ''}</textarea>`;
            }
        }

        // Initialize Quill.js rich text editors
        function initializeQuillEditors() {
            $('.quill-editor').each(function() {
                const editorId = $(this).attr('id');
                const uuid = editorId.replace('editor-', '');

                // Destroy existing editor if it exists
                if (quillEditors[editorId]) {
                    quillEditors[editorId].destroy();
                    delete quillEditors[editorId];
                }

                // Initialize new editor
                const editor = new Quill(`#${editorId}`, {
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
                });

                // Set initial content
                editor.root.innerHTML = $(this).attr('data-content') || '';

                // Update section data when editor content changes
                editor.on('text-change', function() {
                    const sectionIndex = $(`#${uuid}`).data('index');
                    if (typeof sectionIndex !== 'undefined') {
                        sections[sectionIndex].content = editor.root.innerHTML;
                        updateSectionData();
                    }
                });

                quillEditors[editorId] = editor;
            });
        }

        // Handle section type change
        $(document).on('change', 'select', function() {
            const selectedType = $(this).val();
            const accordionItem = $(this).closest('.accordion-item');
            const uuid = accordionItem.attr('id');
            const index = accordionItem.data('index');

            // Update section type
            sections[index].type = selectedType;

            // Initialize content based on type
            if (selectedType === 'faq') {
                sections[index].content = [];
            } else if (selectedType === 'image_slider') {
                sections[index].content = [];
            } else {
                sections[index].content = '';
            }

            // Update content container
            const contentContainer = accordionItem.find('.content-container');
            contentContainer.html(getContentInput(selectedType, sections[index].content, uuid));
            contentContainer.attr('data-section-type', selectedType);

            if (selectedType === 'paragraph' || selectedType === 'heading' || selectedType === 'subheading') {
                // Initialize Quill editors if not already initialized
                initializeQuillEditors();
            }

            updateSectionData();
        });

        // Collect all section data and update the hidden input
        function updateSectionData() {
            // Ensure all FAQ items are collected properly
            $('.faq-container').each(function() {
                const uuid = $(this).attr('id').replace('faq-container-', '');
                const sectionIndex = $(`#${uuid}`).data('index');

                if (typeof sectionIndex !== 'undefined' && sections[sectionIndex].type === 'faq') {
                    collectFaqItems(uuid);
                }
            });

            $('#page_json_hidden').val(JSON.stringify(sections));
        }

        function uploadFile(file) {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('file', file);

                fetch('{{ route('upload.file') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        resolve(data.path);
                    })
                    .catch(error => {
                        console.error('Error uploading file:', error);
                        reject(error);
                    });
            });
        }

        // Handle file selection for image and video sections
        function handleFileSelection(uuid, type) {
            const container = $(`#${uuid} .content-container`);
            const file = $(`#${uuid} input[type="file"]`)[0].files[0];
            if (file) {
                uploadFile(file).then(path => {
                    const sectionIndex = $(`#${uuid}`).data('index');
                    sections[sectionIndex].content = path;
                    container.html(`<img src="${path}" class="img-fluid" />`);
                    $(`#${uuid} .section-content`).val(path);
                    updateSectionData();
                });
            }
        }

        // Handle multiple file selection for image slider
        function handleMultipleFileSelection(uuid) {
            const files = $(`#${uuid} input[type="file"]`)[0].files;
            if (files.length > 0) {
                const sectionIndex = $(`#${uuid}`).data('index');
                const imageUrls = [];
                const container = $(`#image-slider-container-${uuid}`);
                container.html('');

                for (let i = 0; i < files.length; i++) {
                    const objectUrl = URL.createObjectURL(files[i]);
                    imageUrls.push(objectUrl);

                    container.append(`
                        <div class="position-relative me-2 mb-2">
                            <img src="${objectUrl}" class="img-thumbnail" style="height:100px"/>
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeSliderImage('${uuid}', '${objectUrl}')">×</button>
                        </div>
                    `);
                }

                sections[sectionIndex].content = imageUrls;
                
                updateSectionData();
            }
        }

        // Remove an image from the image slider
        function removeSliderImage(uuid, imageUrl) {
            const sectionIndex = $(`#${uuid}`).data('index');
            const content = sections[sectionIndex].content;

            if (Array.isArray(content)) {
                const updatedContent = content.filter(url => url !== imageUrl);
                sections[sectionIndex].content = updatedContent;

                // Update UI
                $(`#image-slider-container-${uuid}`).find(`img[src="${imageUrl}"]`).closest('div').remove();

                updateSectionData();
            }
        }

        // Update content value for text inputs and URLs
        function updateContentValue(uuid, value) {
            const sectionIndex = $(`#${uuid}`).data('index');
            sections[sectionIndex].content = value;
            updateSectionData();
        }

        // Generate template for a FAQ item
        function getFaqItemTemplate(uuid, index, question = '', answer = '') {
            return `
                <div class="faq-item card mb-2" data-faq-index="${index}">
                    <div class="card-body">
                        <div class="mb-2">
                            <label>Question:</label>
                            <input type="text" class="form-control faq-question" value="${question}" oninput="updateFaqItem('${uuid}')"/>
                        </div>
                        <div class="mb-2">
                            <label>Answer:</label>
                            <textarea class="form-control faq-answer" oninput="updateFaqItem('${uuid}')">${answer}</textarea>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger" onclick="removeFaqItem('${uuid}', ${index})">Remove</button>
                    </div>
                </div>
            `;
        }

        // Add a new FAQ item
        function addFaqItem(uuid) {
            const container = $(`#faq-container-${uuid}`);
            const itemCount = container.children().length;
            container.append(getFaqItemTemplate(uuid, itemCount));

            updateFaqItem(uuid);
        }

        // Collect all FAQ items from the UI and update the section data
        function collectFaqItems(uuid) {
            const sectionIndex = $(`#${uuid}`).data('index');
            const faqItems = [];

            $(`#faq-container-${uuid} .faq-item`).each(function() {
                const question = $(this).find('.faq-question').val() || '';
                const answer = $(this).find('.faq-answer').val() || '';
                faqItems.push({
                    question,
                    answer
                });
            });

            sections[sectionIndex].content = faqItems;
        }

        // Update FAQ items when input changes
        function updateFaqItem(uuid) {
            collectFaqItems(uuid);
            updateSectionData();
        }

        // Remove a FAQ item
        function removeFaqItem(uuid, itemIndex) {
            $(`#faq-container-${uuid} .faq-item[data-faq-index="${itemIndex}"]`).remove();

            // Re-index remaining FAQ items
            $(`#faq-container-${uuid} .faq-item`).each(function(idx) {
                $(this).attr('data-faq-index', idx);
                $(this).find('button').attr('onclick', `removeFaqItem('${uuid}', ${idx})`);
            });

            updateFaqItem(uuid);
        }

        // Render all FAQ items for a section
        function renderFaqItems(uuid, items) {
            const container = $(`#faq-container-${uuid}`);
            container.html('');

            if (Array.isArray(items) && items.length > 0) {
                items.forEach((item, index) => {
                    container.append(getFaqItemTemplate(uuid, index, item.question, item.answer));
                });
            } else {
                container.append(getFaqItemTemplate(uuid, 0, '', ''));
            }
        }

        // Render image slider with all images
        function renderImageSlider(uuid, images) {
            const container = $(`#image-slider-container-${uuid}`);
            container.html('');

            if (Array.isArray(images)) {
                images.forEach(imgSrc => {
                    container.append(`
                        <div class="position-relative me-2 mb-2">
                            <img src="${imgSrc}" class="img-thumbnail" style="height:100px"/>
                            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeSliderImage('${uuid}', '${imgSrc}')">×</button>
                        </div>
                    `);
                });
            }
        }

        // Remove a section
        function removeSection(uuid) {
            const index = $(`#${uuid}`).data('index');

            // Remove from sections array
            sections.splice(index, 1);

            // Remove from DOM
            $(`#${uuid}`).remove();

            // Re-index remaining sections and update their headers
            $('#page_json_container .accordion-item').each(function(idx) {
                $(this).data('index', idx);
                $(this).attr('data-index', idx);
                $(this).find('.accordion-button').text(
                    `Section ${idx + 1}: ${sections[idx].type.charAt(0).toUpperCase() + sections[idx].type.slice(1)}`
                    );
            });

            updateSectionData();
        }

        // Form submission handler
        $('form').on('submit', function(e) {
            e.preventDefault();

            // Ensure all Quill editors are updated in the sections data
            $('.quill-editor').each(function() {
                const editorId = $(this).attr('id');
                const uuid = editorId.replace('editor-', '');
                const sectionIndex = $(`#${uuid}`).data('index');

                if (quillEditors[editorId] && typeof sectionIndex !== 'undefined') {
                    sections[sectionIndex].content = quillEditors[editorId].root.innerHTML;
                }
            });

            // Ensure all FAQ items are properly collected
            $('.faq-container').each(function() {
                const uuid = $(this).attr('id').replace('faq-container-', '');
                collectFaqItems(uuid);
            });

            updateSectionData();
            const pageJson = $('#page_json_hidden').val();
            console.log(pageJson);
            // this.submit();
        });
    </script>
@endpush

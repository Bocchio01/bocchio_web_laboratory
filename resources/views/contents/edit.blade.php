<x-layout-minimal :title="'Edit content'" :description="'Form page for edit an existing content'" class="max-w-full">

    <form method="POST" action="{{ route('projects.update', ['id' => $content->id]) }}">
        @csrf
        @method('PUT')

        <!-- Title -->
        <div>
            <x-inputs.label for="title" :value="'Title'" />
            <x-inputs.text id="title" type="text" name="title" required autofocus :value="$content->title" />
            <x-inputs.errorbox :messages="$errors->get('title')" class="mt-2" />
        </div>

        <!-- Slug -->
        <div class="mt-4">
            <x-inputs.label for="slug" :value="'Slug'" />
            <x-inputs.text id="slug" type="text" name="slug" required :value="$content->slug" :readonly="true" />
            <x-inputs.errorbox :messages="$errors->get('slug')" class="mt-2" />
        </div>

        <!-- Published -->
        <div class="mt-4">
            <x-inputs.label for="published" :value="'Published'" />
            <x-inputs.select id="published" name="published" required>
                <option value="0" {{ $content->published == false ? 'selected' : '' }}>False</option>
                <option value="1" {{ $content->published == true ? 'selected' : '' }}>True</option>
            </x-inputs.select>
            <x-inputs.errorbox :messages="$errors->get('published')" class="mt-2" />
        </div>

        <!-- Project Phase -->
        <div class="mt-4">
            <x-inputs.label for="project_phase" :value="'Phase'" />
            <x-inputs.select id="project_phase" name="project_phase" required>
                @foreach (['not_started', 'in_progress', 'completed'] as $phase)
                    <option value="{{ $phase }}" {{ $content->project_phase == $phase ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_', ' ', $phase)) }}
                    </option>
                @endforeach
            </x-inputs.select>
            <x-inputs.errorbox :messages="$errors->get('project_phase')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-inputs.label for="description" :value="'Description'" />
            <x-inputs.textarea id="description" name="description"
                rows="5">{{ $content->description }}</x-inputs.textarea>
            <x-inputs.errorbox :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Image -->
        <div class="mt-4">
            <x-inputs.label for="img" :value="'Image'" />
            <x-inputs.text id="img" name="img" :value="$content->img" />
            <x-inputs.errorbox :messages="$errors->get('img')" class="mt-2" />
        </div>

        <!-- Content -->
        <div class="mt-4">
            <x-inputs.label for="content" :value="'Content'" />
            <x-inputs.textarea id="content" name="content" rows="20">{{ $content->content }}</x-inputs.textarea>
            <x-inputs.errorbox :messages="$errors->get('content')" class="mt-2" />
            <div class="flex items-center justify-center mt-4 gap-4">
                <x-buttons.primary id="addParagraphButton">New paragraph</x-buttons.primary>
                <x-buttons.primary id="addImageButton">New image</x-buttons.primary>
                <x-buttons.primary id="addVideoButton">New video</x-buttons.primary>
                <x-buttons.primary id="addListButton">New list</x-buttons.primary>
            </div>
        </div>

        <!-- Gallery -->
        <div class="mt-4">
            <x-inputs.label for="gallery" :value="'Gallery (JSON)'" />
            <x-inputs.textarea id="gallery" name="gallery"
                rows="5">{{ json_encode($content->gallery, JSON_PRETTY_PRINT) }}</x-inputs.textarea>
            <x-inputs.errorbox :messages="$errors->get('gallery')" class="mt-2" />
        </div>

        <!-- Tags -->
        <div class="mt-4">
            <x-inputs.label for="tags" :value="'Tags (JSON)'" />
            <x-inputs.textarea id="tags" name="tags"
                rows="5">{{ json_encode($content->tags, JSON_PRETTY_PRINT) }}</x-inputs.textarea>
            <x-inputs.errorbox :messages="$errors->get('tags')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4 gap-4">
            <x-buttons.primary type="submit">Save</x-buttons.primary>
            <a href="{{ route('projects.show', ['slug' => $content->slug]) }}">
                <x-buttons.primary role="link"
                    onclick="alert('You are going to lose all your edits. Continue?')">Exit</x-buttons.primary>
            </a>
        </div>
    </form>

</x-layout-minimal>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Title to Slug auto-fill
        const title = document.getElementById('title');
        const slug = document.getElementById('slug');

        title.addEventListener('input', function() {
            slug.value = title.value.slugify();
        });


        // Add a paragraph block to the content textarea
        const contentTextarea = document.getElementById('content');
        const addParagraphButton = document.getElementById('addParagraphButton');
        const addImageButton = document.getElementById('addImageButton');
        const addVideoButton = document.getElementById('addVideoButton');
        const addListButton = document.getElementById('addListButton');


        const ParagraphBlock = `
            <div>
                <h2></h2>
                <p></p>
            </div>
        `;

        const ImageBlock = `
            <figure>
                <img src="" alt="">
                <figcaption></figcaption>
            </figure>
        `;

        const VideoBlock = `
            <figure>
                <video controls>
                    <source src="movie.mp4" type="video/mp4">
                    <source src="movie.ogg" type="video/ogg">
                    Your browser does not support the video tag.
                </video>
                <figcaption></figcaption>
            </figure>
        `;

        const ListBlock = `
            <ul>
                <li></li>
            </ul>
        `;

        addParagraphButton.addEventListener('click', (event) => {
            event.preventDefault();
            insertAtCursor(contentTextarea, ParagraphBlock);
        });

        addImageButton.addEventListener('click', (event) => {
            event.preventDefault();
            insertAtCursor(contentTextarea, ImageBlock);
        });

        addVideoButton.addEventListener('click', (event) => {
            event.preventDefault();
            insertAtCursor(contentTextarea, VideoBlock);
        });

        addListButton.addEventListener('click', (event) => {
            event.preventDefault();
            insertAtCursor(contentTextarea, ListBlock);
        });

    });


    function insertAtCursor(textarea, text) {
        const startPos = textarea.selectionStart;
        const endPos = textarea.selectionEnd;
        const beforeValue = textarea.value.substring(0, startPos);
        const afterValue = textarea.value.substring(endPos, textarea.value.length);

        textarea.value = beforeValue + text + afterValue;
        textarea.selectionStart = textarea.selectionEnd = startPos + text.length;
        textarea.focus();
    }
</script>

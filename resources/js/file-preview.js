/**
 * Previews for file inputs, before anything is uploaded.
 *
 * Attachments: wrap the drop zone, the <input type="file"> and an empty <ul>
 * in an element with [data-attachments]. Images get a thumbnail, other files
 * a name and size; each one can be removed before sending. Files dropped on
 * the zone are put into the input, so they are actually submitted.
 *
 * Avatar: <input type="file" data-avatar-preview="#img-id"> swaps the <img>
 * for the picked image.
 */

const formatSize = (bytes) =>
    bytes < 1024 * 1024 ? `${Math.max(1, Math.round(bytes / 1024))} KB` : `${(bytes / 1024 / 1024).toFixed(1)} MB`;

const fileIcon =
    '<svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>';

function setupAttachments(root) {
    const input = root.querySelector('input[type="file"]');
    const list = root.querySelector('ul');
    const zone = root.querySelector('[data-drop-zone]') ?? root.querySelector('#file_drop_area');
    if (!input || !list) return;

    let urls = [];

    const setFiles = (files) => {
        const transfer = new DataTransfer();
        Array.from(files)
            .slice(0, input.multiple ? undefined : 1)
            .forEach((file) => transfer.items.add(file));
        input.files = transfer.files;
        render();
    };

    const render = () => {
        urls.forEach(URL.revokeObjectURL);
        urls = [];
        list.replaceChildren();
        list.className = 'mt-4 grid gap-3 sm:grid-cols-2';

        Array.from(input.files).forEach((file, index) => {
            const item = document.createElement('li');
            item.className = 'flex items-center gap-3 rounded-xl border border-line bg-white p-2 pr-3';

            const thumb = document.createElement('div');
            thumb.className = 'grid h-14 w-14 shrink-0 place-items-center overflow-hidden rounded-lg bg-canvas text-brand-dark';
            if (file.type.startsWith('image/')) {
                const url = URL.createObjectURL(file);
                urls.push(url);
                const img = document.createElement('img');
                img.src = url;
                img.alt = '';
                img.className = 'h-full w-full object-cover';
                thumb.append(img);
            } else {
                thumb.innerHTML = fileIcon;
            }

            const text = document.createElement('div');
            text.className = 'min-w-0 flex-1 text-sm';
            const name = document.createElement('p');
            name.className = 'truncate font-medium text-ink';
            name.textContent = file.name;
            const size = document.createElement('p');
            size.className = 'text-xs text-ink-mute';
            size.textContent = formatSize(file.size);
            text.append(name, size);

            const remove = document.createElement('button');
            remove.type = 'button';
            remove.className = 'rounded-md px-2 py-1 text-xs font-medium text-ink-mute hover:bg-red-50 hover:text-red-700';
            remove.textContent = 'Remove';
            remove.setAttribute('aria-label', `Remove ${file.name}`);
            remove.addEventListener('click', () => setFiles(Array.from(input.files).filter((_, i) => i !== index)));

            item.append(thumb, text, remove);
            list.append(item);
        });
    };

    input.addEventListener('change', render);

    if (zone) {
        ['dragenter', 'dragover'].forEach((type) =>
            zone.addEventListener(type, (event) => {
                event.preventDefault();
                zone.classList.add('border-brand', 'bg-brand-cyan/5');
            }),
        );
        ['dragleave', 'drop'].forEach((type) =>
            zone.addEventListener(type, (event) => {
                event.preventDefault();
                zone.classList.remove('border-brand', 'bg-brand-cyan/5');
            }),
        );
        zone.addEventListener('drop', (event) => {
            const dropped = Array.from(event.dataTransfer.files);
            setFiles(input.multiple ? [...Array.from(input.files), ...dropped] : dropped);
        });
    }
}

function setupAvatar(input) {
    const img = document.querySelector(input.dataset.avatarPreview);
    if (!img) return;
    const original = img.src;
    let url;

    input.addEventListener('change', () => {
        if (url) URL.revokeObjectURL(url);
        const file = input.files[0];
        if (file && file.type.startsWith('image/')) {
            url = URL.createObjectURL(file);
            img.src = url;
        } else {
            url = null;
            img.src = original;
        }
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-attachments]').forEach(setupAttachments);
    document.querySelectorAll('input[type="file"][data-avatar-preview]').forEach(setupAvatar);
});

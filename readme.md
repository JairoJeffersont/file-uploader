
# FileUploader

**FileUploader** is a lightweight PHP class to handle secure file uploads and deletions.  
It supports MIME type validation, maximum file size checks, automatic directory creation, and file deletion.

## ✨ Features

- Upload files securely with MIME type checking
- Enforce maximum file size (in MB)
- Auto-create target directories if they don't exist
- Option to generate unique file names
- Delete files from the server
- Simple to integrate in any PHP project

## 📦 Installation

Using Composer:

```bash
composer require jairojeffsantos/easy-file-uploader
```

## 🧑‍💻 Usage

### 1. Uploading a file

```php

use EasyFileUploader\FileUploader;

$uploader = new FileUploader();

$result = $uploader->uploadFile(
    __DIR__ . '/uploads',                // Target directory
    $_FILES['file'],                     // File from form
    ['image/jpeg', 'image/png', 'application/pdf'],         // Allowed MIME types
    5                                    // Max file size in MB
);

print_r($result);

/*
Possible return (success):
Array
(
    [status] => success
    [message] => File uploaded successfully.
    [file_path] => /your/project/uploads/file_643f3a9c8e2d0.png
)

Possible return (error):
Array
(
    [status] => format_not_allowed
    [message] => File type not allowed.
)

Array
(
    [status] => max_file_size_exceeded
    [message] => File exceeds the limit of {$maxSize} MB.
)
*/

```

### 2. Deleting a file

```php
$result = $uploader->deleteFile(__DIR__ . '/uploads/file_abc123.png');
print_r($result);

/*
Possible return (success):
Array
(
    [status] => success
    [message] => File deleted successfully.
)

Possible return (error):
Array
(
    [status] => file_not_found
    [message] => 'File not found.
)
*/

```

## ✅ Example Form (HTML)

```html
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="file" />
    <button type="submit">Upload</button>
</form>
```

## 🔒 Security Tips

- Always validate MIME type server-side.
- Set correct file/folder permissions on your server.
- Avoid allowing executable file types (e.g., `.php`, `.exe`).

## 📄 License

MIT License

# EasyUpload

EasyUpload é uma biblioteca PHP simples para gerenciar uploads e exclusão de arquivos com segurança, validação de tipo e tamanho, e suporte à geração de nomes únicos.

## Funcionalidades

* Upload seguro de arquivos com validação de MIME type.
* Verificação do tamanho máximo do arquivo.
* Criação automática de diretórios, caso não existam.
* Geração de nomes únicos para evitar conflitos de arquivos.
* Exclusão segura de arquivos do servidor.

## Instalação

Para instalar via Composer:

```bash
composer require jairojeffersont/file-uploader
```

## Estrutura de Pastas

```
easy-upload/
├─ src/
│  └─ FileUploader.php
├─ composer.json
└─ README.md
```

## Uso

### Upload de Arquivo

```php
use JairoJeffersont\FileUploader;

$file = $_FILES['arquivo'];
$allowedTypes = ['image/jpeg', 'image/png'];
$maxSize = 5; // tamanho máximo em MB

$result = FileUploader::uploadFile(__DIR__ . '/uploads', $file, $allowedTypes, $maxSize);

if ($result['status'] === 'success') {
    echo "Arquivo enviado com sucesso: " . $result['file_path'];
} else {
    echo "Erro no upload: " . $result['status'];
}
```

### Exclusão de Arquivo

```php
use JairoJeffersont\FileUploader;

$result = FileUploader::deleteFile(__DIR__ . '/uploads/file_abc123.png');

if ($result['status'] === 'success') {
    echo "Arquivo excluído com sucesso!";
} else {
    echo "Erro ao excluir arquivo: " . $result['status'];
}
```

## Boas Práticas

* Sempre validar o tipo MIME e tamanho dos arquivos antes de permitir o upload.
* Evite usar nomes de arquivos enviados pelo usuário sem sanitização.
* Configure corretamente `upload_max_filesize` e `post_max_size` no `php.ini`.
* Use diretórios separados para uploads públicos e privados.

## Contribuição

Contribuições são bem-vindas! Abra uma issue ou envie um pull request para melhorias, correções de bugs ou novas funcionalidades.

## Licença

MIT License

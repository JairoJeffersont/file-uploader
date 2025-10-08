<?php

namespace JairoJeffersont;

/**
 * Classe FileUploader
 * 
 * Gerencia uploads de arquivos, incluindo:
 * - Validação de tipo e tamanho do arquivo.
 * - Criação automática de diretórios.
 * - Geração de nomes únicos.
 * - Exclusão de arquivos do servidor.
 * 
 * @package JairoJeffersont
 */
class FileUploader {
    /**
     * Realiza o upload de um arquivo para o diretório especificado.
     *
     * @param string $directory Diretório onde o arquivo será armazenado.
     * @param array $file Dados do arquivo, normalmente provenientes de $_FILES.
     * @param array $allowedTypes Tipos MIME permitidos para upload. Ex.: ['image/jpeg', 'image/png'].
     * @param int $maxSize Tamanho máximo permitido em MB.
     * @param bool $uniqueFlag Se verdadeiro, gera um nome único para evitar conflitos.
     * 
     * @return array Retorna um array associativo com:
     *               - 'status' (string): 'success' ou mensagem de erro.
     *               - 'file_path' (string, opcional): caminho do arquivo salvo, presente apenas em sucesso.
     */
    public static function uploadFile(string $directory, array $file, array $allowedTypes, int $maxSize, bool $uniqueFlag = true): array {
        // Verifica erros no upload
        if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
            return ['status' => 'erro_no_upload', 'error_code' => $file['error'] ?? 'desconhecido'];
        }

        // Verifica se o arquivo existe temporariamente
        if (!is_uploaded_file($file['tmp_name'])) {
            return ['status' => 'arquivo_temporario_invalido'];
        }

        // Determina o MIME type e a extensão do arquivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileMime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Valida o tipo do arquivo
        if (!in_array($fileMime, $allowedTypes, true)) {
            return ['status' => 'formato_nao_permitido'];
        }

        // Valida o tamanho do arquivo
        if ($file['size'] > $maxSize * 1024 * 1024) {
            return ['status' => 'tamanho_maximo_excedido'];
        }

        // Cria o diretório se não existir
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            return ['status' => 'falha_criacao_diretorio'];
        }

        // Gera nome de arquivo seguro
        $fileName = $uniqueFlag
            ? uniqid('file_') . '.' . $fileExtension
            : preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
        $destination = $directory . DIRECTORY_SEPARATOR . $fileName;

        // Verifica se o arquivo já existe
        if (file_exists($destination)) {
            return ['status' => 'arquivo_ja_existe'];
        }

        // Move o arquivo para o diretório destino
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return ['status' => 'falha_movimentacao'];
        }

        return ['status' => 'success', 'file_path' => str_replace('\\', '/', $destination)];
    }

    /**
     * Exclui um arquivo do servidor.
     *
     * @param string $filePath Caminho completo do arquivo a ser deletado.
     * 
     * @return array Retorna um array associativo com:
     *               - 'status' (string): 'success' ou mensagem de erro.
     */
    public static function deleteFile(string $filePath): array {
        // Ajusta o separador de diretório
        $filePath = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $filePath);

        // Verifica se o arquivo existe
        if (!file_exists($filePath)) {
            return ['status' => 'arquivo_nao_encontrado'];
        }

        // Tenta deletar o arquivo
        if (!unlink($filePath)) {
            return ['status' => 'falha_exclusao'];
        }

        return ['status' => 'success'];
    }
}

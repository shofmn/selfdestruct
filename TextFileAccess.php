<?php
class TextFileAccess {
    private $filename;

    public function __construct($filename) {
        $this->filename = $filename;
    }

    public function readAllLines() {
        if (!file_exists($this->filename)) {
            return [];
        }
        return file($this->filename, FILE_IGNORE_NEW_LINES);
    }

    public function updateLine($lineNumber, $newContent) {
        $lines = $this->readAllLines();
        $lineNum = intval($lineNumber);
        
        if ($lineNum < 0 || $lineNum >= count($lines)) {
            throw new InvalidArgumentException("Invalid line number");
        }

        $lines[$lineNum] = $newContent;
        $this->writeLines($lines);
    }

    public function appendLine($content) {
        // Check if file exists and doesn't end with a newline
        if (file_exists($this->filename) && file_get_contents($this->filename, false, null, -1) !== "\n") {
            // If file doesn't end with newline, add one before the new content
            $content = PHP_EOL . $content;
        }
        file_put_contents($this->filename, $content . PHP_EOL, FILE_APPEND);
    }

    public function deleteLine($lineNumber) {
        $lines = $this->readAllLines();
        $lineNum = intval($lineNumber);
        
        if ($lineNum < 0 || $lineNum >= count($lines)) {
            throw new InvalidArgumentException("Invalid line number");
        }

        array_splice($lines, $lineNum, 1);
        $this->writeLines($lines);
    }

    private function writeLines($lines) {
        file_put_contents($this->filename, implode(PHP_EOL, $lines));
    }
}

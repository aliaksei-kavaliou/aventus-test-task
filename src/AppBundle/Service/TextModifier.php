<?php

namespace AppBundle\Service;

/**
 * Description of TextModifier
 *
 * @author aliaksei
 *
 * @todo Preserve original delimiters
 */
class TextModifier
{
    const THREE = "три";
    const FIVE = "пять";
    const FIFTEEN = "пятнадцать";

    /**
     * Read $in file, modify content and write result to $out file
     * @param string $in
     * @param string $out
     * @throws \Exception
     */
    public function run($in, $out)
    {
        $handle = fopen($out, "w");

        if (!$handle) {
            throw new \Exception("Output file can not be created");
        }

        $offset = 0;

        foreach ($this->readFile($in) as $line) {
            if (!mb_check_encoding($line, 'UTF-8')) {
                fclose($handle);
                throw new \Exception('File must be UTF-8 encoded');
            }

            $mLine = $this->modify(trim($line), $offset);

            if (false === fwrite($handle, $mLine.(PHP_EOL == mb_substr($line, -1) ? PHP_EOL : ''))) {
                fclose($handle);
                throw new \Exception('Error happen on write');
            }
        }

        fclose($handle);
    }

    /**
     * Reaf file line by line
     * @param string $filename File path
     * @return \Generator
     * @throws \Exception
     * @todo limit fgets length and prevent multibyte sumbole cut
     */
    public function readFile($filename)
    {
        $handle = fopen($filename, 'r');

        if (!$handle) {
            throw new \Exception('File not found, or can not be read');
        }

        try {
            while ($line = fgets($handle)) {
                yield $line;
            }
        } finally {
            fclose($handle);
        }
    }

    /**
     * Replace words in required positions with relevant constants
     * @param string  $chunk
     * @param integer $offset
     * @return string
     */
    public function modify($chunk, &$offset)
    {
        $pieces = preg_split('/\p{Zs}/', $chunk);
        $offset++;

        foreach ($pieces as $key => &$value) {

            if (0 === ($key + $offset) % 15) {
                $value = $this->exchange($value, self::FIFTEEN);
                continue;
            }

            if (0 === ($key + $offset) % 5) {
                $value = $this->exchange($value, self::FIVE);
                continue;
            }

            if (0 === ($key + $offset) % 3) {
                $value = $this->exchange($value, self::THREE);
            }
        }
        unset($value);

        $offset += $key;

        return implode(' ', $pieces);
    }

    /**
     * Exchange value and preserve case
     * @param string $subject
     * @param string $replacement
     * @return string
     */
    private function exchange($subject, $replacement)
    {
        $nValue = mb_ereg_replace('[\P{P}]+', $replacement, $subject);
        $isUpper = mb_convert_case(mb_substr($subject, 0, 1), MB_CASE_UPPER, "UTF-8") === mb_substr($subject, 0, 1);

        if (!$isUpper) {
            return $nValue;
        }

        return mb_convert_case(mb_substr($nValue, 0, 1), MB_CASE_UPPER, "UTF-8").mb_substr($nValue, 1);
    }
}

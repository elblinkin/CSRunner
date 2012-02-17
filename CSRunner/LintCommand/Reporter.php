<?php

namespace CSRunner\LintCommand;

use XmlWriter;

class Reporter {

    private $writer;

    public function __construct(XmlWriter $writer) {
        $this->writer = $writer;
    }

    public function report(array $results) {
        $this->writer->setIndent(true);
        $this->writer->startDocument('1.0', 'UTF-8');
        $this->writer->startElement('checkstyle');
        foreach ($results as $result) {
            $this->writer->startElement('file');
            $this->writer->writeAttribute('name', $result['name']);
            foreach ($result['errors'] as $error) {
                $this->writer->startElement('error');
                $this->writer->writeAttribute('line', $error['line']);
                $this->writer->writeAttribute('message', $error['message']);
                $this->writer->writeAttribute('severity', $error['severity']);
                $this->writer->writeAttribute('source', $error['source']);
                $this->writer->endElement();
            }
            $this->writer->endElement();
        }
        $this->writer->endElement();
    }
}
<?php

namespace FluentFormPro\Integrations\GoogleSheet\API;


class Sheet
{
    private $api;

    public function __construct()
    {
        $this->api = new API();
    }

    public function getHeader($sheetId, $workSheetName)
    {
        $url = 'https://sheets.googleapis.com/v4/spreadsheets/'.$sheetId.'/values/'.$workSheetName.'!A1:Z1';
        $headers = [
            'Authorization' => 'OAuth '.$this->api->getAccessToken()
        ];
        return $this->api->makeRequest($url, [], 'GET', $headers);
    }

    public function insertHeader($sheetId, $workSheetName, $row, $range = 'auto')
    {
        $range = $workSheetName.'!A1:'.$this->getRangeKey(count($row)).'1';
        $this->clear($sheetId, $range);
        $rowValues = array_values($row);
        $url = 'https://sheets.googleapis.com/v4/spreadsheets/'.$sheetId.'/values/'.htmlspecialchars($range).'?includeValuesInResponse=true&responseDateTimeRenderOption=FORMATTED_STRING&responseValueRenderOption=UNFORMATTED_VALUE&valueInputOption=RAW';

        return $this->api->makeRequest($url, [
            'values' => [$rowValues],
            'majorDimension' => 'ROWS',
            'range' => $range
        ], 'PUT', $this->getStandardHeader());
    }

    public function insertRow($sheetId, $workSheetName, $row)
    {
        $range = $workSheetName.'!A1:'.$this->getRangeKey(count($row)).'1';
        $url = 'https://sheets.googleapis.com/v4/spreadsheets/'.$sheetId.'/values/'.htmlspecialchars($range).':append?includeValuesInResponse=true&insertDataOption=INSERT_ROWS&responseDateTimeRenderOption=SERIAL_NUMBER&responseValueRenderOption=UNFORMATTED_VALUE&valueInputOption=RAW';
        $rowValues = array_values($row);

        return $this->api->makeRequest($url, [
            'values' => [$rowValues]
        ], 'POST', $this->getStandardHeader());
    }

    private function clear($sheetId, $range)
    {
        $url = 'https://sheets.googleapis.com/v4/spreadsheets/'.$sheetId.'/values/'.$range.':clear';

        return $this->api->makeRequest($url, [], 'POST', $this->getStandardHeader());
    }

    private function getRangeKey($number)
    {
        $indexes = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
        if($number <= 26) {
            $index = $number - 1;
            return $indexes[$index];
        }
        return 'Z';
    }

    private function getStandardHeader()
    {
        return [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer '.$this->api->getAccessToken()
        ];
    }
}
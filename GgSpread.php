<?php
class GgSpread {
    private $spreadsheet;
    // 書き込みたいスプレッドシート名
    private $spreadsheetName;
    // 書き込みたいスプレッドシートのワークシート名
    private $worksheetName;
    // スプレッドシートキー
    private $spreadsheetKey;
    // ワークシートキー
    private $worksheetKey;
    // 書き込む内容
    private $output;
    
    public function __construct($email, $passwd, $spreadsheetName, $worksheetName){
        $this->spreadsheetName = $spreadsheetName;
        $this->worksheetName = $worksheetName;
        require_once 'Zend/Loader.php';
        Zend_Loader::loadClass('Zend_Gdata');
        Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
        Zend_Loader::loadClass('Zend_Gdata_Spreadsheets');
        
        $service = Zend_Gdata_Spreadsheets::AUTH_SERVICE_NAME;

        // 認証済みHTTPクライアント作成(ClientLogin版)
        $client = Zend_Gdata_ClientLogin::getHttpClient($email, $passwd, $service);

        // Spreadsheetサービスのインスタンス作成
        $this->spreadsheet = new Zend_Gdata_Spreadsheets($client);
        // スプレッドシートのキー検索
        //フィード(XML形式のスプレッドシート一覧）の取得
        $spreadsheetFeed = $this->spreadsheet->getSpreadsheetFeed();
        // スプレッドシートのキー取得
        $i = 0;
        foreach($spreadsheetFeed->entries as $spreadsheetEntry) {
            if( $spreadsheetEntry->title->text===$this->spreadsheetName) {
                $key = split('/', $spreadsheetFeed->entries[$i]->id->text);
                $this->spreadsheetKey = $key[5];
                break;
            }
            $i++;
        }
        /* ワークシートのID取得 */
        // クエリの作成
        $documentQuery = new Zend_Gdata_Spreadsheets_DocumentQuery();
        $documentQuery->setSpreadsheetKey($this->spreadsheetKey);

        // ワークシートフィードの取得
        $spreadsheetFeed = $this->spreadsheet->getWorksheetFeed($documentQuery);

        // ワークシートの検索
        $i = 0;
        foreach($spreadsheetFeed->entries as $worksheetEntry) {
            $worksheetId = split('/', $spreadsheetFeed->entries[$i]->id->text);
            if( $worksheetEntry->title->text===$this->worksheetName ){
                $this->worksheetKey = $worksheetId[8];
                //echo("ワークシートのID:{$sWorksheetId}<br>");
                break;
            }
            $i++;
        }
    }
     
    /*
     *  set output data
     *  @param array("cel1" => "", "cel2" => ""...)
     */
    public function set($outputData = array()){
        $this->output = $outputData;
    }
    
    /*
     *  insert output data
     */
     public function insert(){
         return $this->spreadsheet->insertRow($this->output, $this->spreadsheetKey, $this->worksheetKey);
     }
}

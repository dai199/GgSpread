Easy Writing Google Spreadsheet
----------------

GgSpreadは、Google Spreadsheetに簡単に書込が出来るPHPラッパーです。

# 依存関係
---

[Zendフレームワーク v1](http://framework.zend.com/)

# 使い方
----------------

### 1, Zendフレームワークをインストールする
ZendフレームワークのGdataというライブラリを使用するのでそこまでのパスを通しておいてください。

### 2, Googleスプレッドシートを作成する
事前に1行目に項目を入れておきましょう。

### 3, GgSpreadをインクルードする
Googleドキュメントに書込をしたいスクリプト内でGgSpreadをインクルードします。

`require_once 'GgSpread.php';`


### 4, インスタンスを作成する
引数として、Googleアカウントのメールアドレス、パスワード、書込をしたいスプレッドシート名、書込をしたいスプレッドシートのワークシート名が必要です。

    $ggspread = new GgSpread('メールアドレス', 'パスワード', 'スプレッドシート名', 'ワークシート名');

### 5, 書き込みたいデータをsetする
書込したいデータを連想配列でsetします。

    $output = array(
      'cel1' => 'test1',
      'cel2' => 'test2',
      'cel3' => 'test3'
    );
    $ggspread->set($output);

### 6, insertする

    $ggspread->insert();
    
    


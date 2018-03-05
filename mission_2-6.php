<html>

<!-2-2で作成されたテキストファイルを読み込み、2-1のフォームのすぐ下に表示する。表示の際にループ関数を使うこと。->

<head>
<meta charset = "utf-8" />
<title>シネマよざくん</title>
</head>

<body>

<!-フォームの上部に見出しをつける->
<h1>お気に入りの映画・ドラマ・アニメ</h1>

<!-formタグでブラウザ上に入力フォームを作成する->
<form method="post" action="mission_2-6.php">


<!-編集1->
<?php
$edi = htmlspecialchars($_POST["editingNo"]); //ポインタへ格納(編集対象番号)

$ediP =  htmlspecialchars($_POST["editingPassword"]);

$pas = htmlspecialchars($_POST["Password"]);

if(!empty($edi)){ //b. if文で編集フォームの値がある場合処理が分岐するようにする
	
	if(!empty($ediP)){
		
			$filename = 'ryukyu2-6.txt';
			
			$fp = fopen($filename, 'ab'); //ryukyu2-6を書き込み
			
			//ryukyu2-5の中身を回すために$editingにryukyu2-6の中身を移す
			$editing = file($filename); //c. テキストファイルをfile関数で読み込む
			
			//ループ関数を使って投稿番号を取得
			for($i = 0 ; $i < count($editing) ; $i++){ //c.配列から1つずつ取り出す
				
				$data = explode("<>",$editing[$i]); //d. 文字列を分解
				
				if($edi == $data[0] && $ediP == $data[4]){ //e. 各投稿番号とPOSTで送信された編集番号を比較し、イコールの時の配列の値（名前とコメントの値）を取得する
				
					$edit_num = $data[0]; //番号
					
					$edit_Pas = $data[4]; //パスワード
					
					$user = $data[1]; //名前
					
					$comment = $data[2]; //コメント
					
				}
				
				
			}
			
			if($edi == $data[0] && $ediP != $data[4]){
			
				echo "パスワードが違います。";
				
			}
			
			fclose($fp);
			
			
		
	}else{
		echo'パスワードが入力されていません。';
	}

}
?>


<!-f. eで取得した配列値を入力済み状態で表示させる（名前とコメントがフォームに入力されている状態のこと）->
<!- g.その値をPOSTで送信して編集を行うが、編集かどうかわかるようにhiddenタグを新たに用意し、hiddenの値に応じて編集モードかどうかを判別する->

<p>
<input type="hidden" name="edit_num" value="<?php echo $edit_num; ?>"/>
<input type="hidden" name="edit_Pas" value="<?php echo $edit_Pas; ?>"/><!-g.その値をPOSTで送信して編集するが、編集かどうかわかるようにhiddenタグを新たに用意した。->
お名前<br>
<input type="text" name="user" placeholder="お名前"  value= "<?php echo $user ; ?>"/><br><!-f. eで取得した配列値を入力済み状態で表示させる（名前とコメントがフォームに入力されている状態のこと）->

コメント<br>
<input type="text" name="comment" placeholder="コメント" value="<?php echo $comment ;?>"/><!-f. eで取得した配列値を入力済み状態で表示させる（名前とコメントがフォームに入力されている状態のこと）-><br>
パスワード<br>
<input type="text" name="Password" placeholder="パスワード" value="<?php echo $edit_Pas ;?>"/><br><!-a.入力フォームの項目にパスワードを追加する->
<input type="reset"/>
<input type="submit" name="sousin"/><br>
</p>
<br>



<!-削除->
<?php
$del = htmlspecialchars($_POST["deleteNo"]); //ポインタへ格納(削除対象番号)
	
$delP = htmlspecialchars($_POST["del_Password"]); //ポインタへ格納(削除対象パスワード)
	
//if文で削除フォームの値がある場合処理が分岐する様にする
if(!empty($_POST["deleteNo"])){ //削除番号がないと実行しない

		//echo "if1に入れる!<br>";
		
	if(!empty($_POST["del_Password"])){ //削除パスワードがないと実行しない
		
		//echo "if2に入れる!<br>";
		
		$filename = 'ryukyu2-6.txt';
			
		$delete = file($filename); //テキストファイルをfile関数で読み込む
			
		//ループ関数を使って投稿番号を取得
		foreach($delete as $line){ //配列から1つずつ取り出す
			
			$deleteH = explode('<>',$line); //<>で切って配列に!
				
			//echo '$deleteH=';
			//print_r($deleteH);
			//echo "<br>";
			//echo "deleteNo=".$_POST["deleteNo"]."<br>";
			//echo 'deleteH[0]='.$deleteH[0]."<br>";
		
		
			if($del == $deleteH[0] && $delP == $deleteH[4]){
			
				//echo "if3に入れる!";
				$match = $deleteH[4];
				
			}
			else if($_POST["del_Password"] != $deleteH[4]){
				//echo "if4に入れている<br>";
				//echo "パスワードが違います。<br>";
				//echo "del_Password=".$_POST["del_Password"]."<br>";
				//echo '$deleteH[4]='.$deleteH[4]."<br>";
			
			}
		}
		
	}else{
		echo"パスワードが入力されていません。";//番号が等しい時だけ何もしない事で削除される
	}

}

?>
			
<!-削除->
<?php
$del = htmlspecialchars($_POST["deleteNo"]); //ポインタへ格納(削除対象番号)

$delP = htmlspecialchars($_POST["del_Password"]); //ポインタへ格納(削除対象パスワード)

//if文で削除フォームの値がある場合処理が分岐する様にする
if(!empty($_POST["deleteNo"]) && !empty($match)){
	
	//echo "if5に入れている!<br>";
	
	$filename = 'ryukyu2-6.txt';
			
	$delete = file($filename); //テキストファイルをfile関数で読み込む
			
	//新規テキストファイルをwモードで開く
	$fp = fopen($filename,'w+');
			
	$j = 1 ;
			
	//ループ関数を使って投稿番号を取得
	foreach($delete as $line){ //配列から1つずつ取り出す
			
		$deleteH = explode('<>',$line); //<>で切って配列に!
			
		//$deleteH[0]に投稿番号格納中
		//1行ずつ見て行った時に削除フォームが入力された値と投稿番号が格納されている$deleteH[0]が等しくない時、それ以外の投稿を新しく書き込む。
		
		// d.入力されたパスワードと、書き込み時に保存したパスワードを比較し、一致の場合のみ削除機能が動作するようにする
		if($deleteH[0] != $del){ //「$delと違う」時に処理
			
			//echo "if6に入れている<br>";
			//投稿を変数$hairetuに格納
			$hairetu = $j."<>".$deleteH[1]."<>".$deleteH[2]."<>".$deleteH[3]."<>".$deleteH[4]."<>";
					
					
			fputs($fp, $hairetu."\n"); //ファイルに追記
					
			$j++;
				
		//}
		/*if($deleteH[0] == $del && $deleteH[4] != $delP){
				
			fputs($fp,$line); //パスワードが違う時はデータが残る様にする。
				
		}//この場合、削除番号またはパスワードがあれば削除される仕組みになっている。
		
		if($deleteH[0] != $del && $deleteH[4] == $delP){
			echo"番号が違います。";
		}
		
		/*if($deleteH[0] == $del && $deleteH[4] == $delP){
			$hairetu = $j."<>".$deleteH[1]."<>".$deleteH[2]."<>".$deleteH[3]."<>".$deleteH[4]."<>";
					
			fputs($fp, $hairetu."\n"); //ファイルに追記
					
			$j++;*/
		}
	}
	
	fclose($fp); //ファイルを閉じる
}

?>



<p>
<!-フォームで「削除対象番号」をつける。->
削除対象番号<br>
<input type="text" name="deleteNo"><br>
パスワード<br>
<input type="text" name="del_Password"><br><!-c.削除の際に、パスワードの入力を求める。->
<input type="submit" name="delete" value="削除"><br>
</p>
<br>

<p>
<!-a. formで「編集対象番号」をつける->
編集対象番号<br>
<input type="text" name="editingNo"><br>
パスワード<br>
<input type="text" name="editingPassword"><br><!-c.編集の際に、パスワードの入力を求める。->
<input type="submit" name="editing" value="編集"><br>
</p>

</form>


<!-フォームで送信された入力値を受け取り、テキストファイルに保存する。->
<?php
//b.テキストファイルへの保存の際にも、パスワードが保存されるように変更する
if(empty($_POST['edit_num'])){
	
	//テキストファイルに番号名前時間を1行ずつ表示して保存
	
	//文字データを変数に代入
	$user = htmlspecialchars($_POST["user"]); //ポインタへ格納(名前)
	
	$comment = htmlspecialchars($_POST["comment"]); //ポインタへ格納(コメント内容)
	
	$Password = htmlspecialchars($_POST["Password"]); //ポインタへ格納(パスワード)
	
	$time = date("Y/m/d/H:i:s"); //日時に変更して偏すに格納
	
	$filename = 'ryukyu2-6.txt'; //テキストファイル名を変数$filenameに代入
	
	//まずはfopenのaモード（追加書き込みモード）でファイルを開く
	$fp = fopen($filename,'a');
	
	//読み込みの際はfile関数を用いれば、簡単に配列として読み込める
	//配列関数：要素の数を数える
	//配列として読み込んで変数に格納
	$array = file($filename);
	
	$count = count($array) + 1; //配列の数をcountして変数に格納
	
	$text = $count."<>".$user."<>".$comment."<>".$time."<>".$Password."<>" ; //変数の結合
	
	//fopenで開いたテキストファイルに受け取った文字データを書き込む
	//ifで$test1と$tese2が入力される時のみfwriteを行う
	if(!empty($_POST["user"])){
	
		if(!empty($_POST["comment"])){
		
			if(!empty($_POST["Password"])){
			
				fwrite($fp, $text."\n");
				
			}
		}
	}
	fclose($fp);
}

?>



<!-編集2->
<!-g.hiddenの値に応じて編集モードかどうかを判別する->
<?php
if(!empty($_POST["edit_num"]) && !empty($_POST["edit_Pas"])){
		
	$edi = htmlspecialchars($_POST["editingNo"]); //ポインタへ格納(編集対象番号)
		
	$edit_num = htmlspecialchars($_POST["edit_num"]); //ポインタへ格納(編集内容「番号」)
	
	$edit_Pas = htmlspecialchars($_POST["edit_Pas"]); //ポインタへ格納(編集内容「パスワード」)
		
	$user = htmlspecialchars($_POST["user"]); //ポインタへ格納(名前)
		
	$comment = htmlspecialchars($_POST["comment"]); //ポインタへ格納(コメント)
		
	$Password = htmlspecialchars($_POST["Password"]); //ポインタへ格納(パスワード)
		
	$time = date("Y/m/d H:i:s"); //日時に変更して偏すに格納
		
	//if(!empty($edi)){ //b. if文で編集フォームの値がある場合処理が分岐するようにする
		
	$filedata = file('ryukyu2-6.txt'); //1行(1投稿)ずつ配列に格納する。 c. テキストファイルをfile関数で読み込む
		
	$fp = fopen('ryukyu2-6.txt','w+'); //空にして開く‼︎
		
	foreach($filedata as $line){ //配列から1つずつ取り出す
			
		$data = explode('<>',$line); //<>で切って配列に!
			
		//echo"check_ifl|".$data[0]."|".$edit_num."|<hr>"; //デバッグ領域
			
		//if($Password == $_POST["edit_Password"]){ // d.入力されたパスワードと、書き込み時に保存したパスワードを比較し、一致の場合のみ編集機能が動作するようにする
			
			if($data[0] == $edit_num && $data[4] == $edit_Pas){ //投稿内容が編集番号と編集パスワードと同じなら括弧の中処理
			
				$text = $edit_num[0]."<>".$user."<>".$comment."<>".$time."<>".$edit_Pas[0]."<>"."<br>";
			
				fputs($fp,$text."\n"); //編集した1行をファイルに追記
			
			}else{ //一致しないときは元のデータをそのまま書き込み
				fputs($fp,$line); //元の1行をファイルに追記
			}
			
		//}
		
		for($i = 0 ; $i < count($filedata) ; $i++){ //c.配列から1つずつ取り出す
			
			$data2 = explode("<>",$filedata[$i]); //d. 文字列を分解
			
			//if($Password == $data2[4]){ // d.入力されたパスワードと、書き込み時に保存したパスワードを比較し、一致の場合のみ編集機能が動作するようにする
			
				if($edi == $data2[0]){ //e. 各投稿番号とPOSTで送信された編集番号を比較し、イコールの時の配列の値（名前とコメントの値）を取得する
				
					'番号: '.$data2[0].'<br/>'; //投稿番号
				
					$data2[2].'<br/>'; //コメント内容
				
					'By:'.$data2[1].'<br/>'; //氏名
				
					'パスワード:'.$data2[4].'<br/>'; //パスワード
				
					'投稿日時:'.$data2[3].'<br/>'; //投稿日時
				
					'<hr />'; //区切りの見栄えの為の水平線。
				}
			//}
		}
	}
	fclose($fp); //ファイルを閉じる
}

//}


/*if(isset($comment)){
	echo '$comment はあります。<br>';
	} else{
		echo 'ないです。<br>';
	}
	
if(isset($user)){
	echo '$user はあります。<br>';
	} else{
		echo 'ないです。<br>';
	}

if(isset($time)){
	echo '$time はあります。<br>';
	} else{
		echo 'ないです。<br>';
	}*/


?>

<!-echoでのweb上に表示->
<?php
//explodeで文字列を分解して、echoで表示する
//ループ関数を利用した繰り返し処理で配列のデータを、1回の投稿（フォーム入力）ごとに改行してブラウザで表示させる。
$filename = 'ryukyu2-6.txt';

$contents = file($filename);

for($i=0 ; $i < count($contents) ; $i++){
	
	$text4 = explode("<>",$contents[$i]); //文字列を分解
	
	echo '番号: '.$text4[0].'<br/>'; //投稿番号
	
	echo $text4[2].'<br/>'; //コメント内容
	
	echo 'By:'.$text4[1].'<br/>'; //氏名
	
	echo '投稿日時:'.$text4[3].'<br/>'; //投稿日時
	
	echo '<hr />'; //区切りの見栄えの為の水平線。
}
?>


</body>

</html>

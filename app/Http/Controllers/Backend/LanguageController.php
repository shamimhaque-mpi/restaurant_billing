<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	} 

	
	public function insert(Request $request)
	{
		$chk = 0;
		for ($i=0; $i < 2; $i++) {
			if ($i == 0) {
				$type = 'bn';
			} else {
				$type = 'en';
			}
			// load the data and delete the line from the array 
			$lines = array_values(array_unique(file('resources/lang/'.$type.'/'.$request->place.'/'.$request->name.'.php')));
			$tag__ = $request->tag;
			$str = "\t'".$tag__."' => '".$request->$type."',\r\n";
			
			foreach ($lines as $line) {
				if ($line == $str && $chk == 0) {
					$active = 'lang';
					$chk = 1;
					session()->flash('exist_message', 'Already Exist');
					return view('backend.pages.language.index', compact('active'));
					die();
				}
			}

			$total_line = sizeof($lines);
			$total_line --;
			if ($lines[$total_line] == "];\r\n") {
				$lines[$total_line] = "];";
			}
			$last = sizeof($lines) - 1;
			unset($lines[$last]);

			// write the new data to the file 
			$fp = fopen('resources/lang/'.$type.'/'.$request->place.'/'.$request->name.'.php', 'w');
			fwrite($fp, implode('', $lines));
			fclose($fp);
			//$txt = "\t'".$request->tag."' => '".$request->$type."',\r\n];";
			$txt = $str."];";

			file_put_contents('resources/lang/'.$type.'/'.$request->place.'/'.$request->name.'.php', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		}
		$active = 'lang';
		if ($chk == 0) {
			session()->flash('add_message', 'Added');
			return view('backend.pages.language.index', compact('active'));
		}
	}

	
	public function language()
	{
		$active = 'lang';
		return view('backend.pages.language.index', compact('active'));
	}


	public function create(Request $request)
	{
		$content = "<?php\n\nreturn [\n];";

		$fp = fopen('resources/lang/bn/'.$request->place.'/'.$request->name.'.php','wb');
		fwrite($fp,$content);
		fclose($fp);

		$fp = fopen('resources/lang/en/'.$request->place.'/'.$request->name.'.php','wb');
		fwrite($fp,$content);
		fclose($fp);

		$active = 'lang';
		//session()->flash('success_message', 'File Created Successfully');
		session()->flash('add_message', 'Added');
		return redirect()->route('admin.language.index', compact('active'));
	}
}

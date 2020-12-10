<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ImageUploadHelper;
use Artisan;

class BackupController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth:admin');
	}


	public function index()
	{
    	// directory we want to scan
		$dircontents = scandir(base_path('database/backup-db'));
		rsort($dircontents);
		//dd(date('H:i:s'));
		return view('backend.pages.backup.index', compact('dircontents'));
	}


	public function newBackup()
	{
		Artisan::call('backup:run --only-db');

		session()->flash('add_message', 'Succesfully Saved');
		return redirect()->route('admin.backup.index');
	}


	public function restoreBackup(Request $request)
	{
		function deleteFolder($sql_path) {
			if (file_exists($sql_path)) {
				array_map('unlink', glob($sql_path."*.*"));
				array_map('unlink', array_diff(glob($sql_path.".*"), array($sql_path.".", $sql_path."..")));
				rmdir($sql_path);
			}
		}

		$db_name = env('DB_DATABASE');

		$zip_path = 'database/backup-db/';
		$zip_name = $request->zip_name;

		$sql_path = $zip_path.'db-dumps/';
		$sql_name = 'mysql-'.$db_name.'.sql';

		deleteFolder($sql_path);

		$zip_full_path = $zip_path.$zip_name;
		$sql_full_path = $sql_path.$sql_name;

		$zip = new \ZipArchive;
		$res = $zip->open($zip_full_path);
		if ($res === TRUE) {
			$zip->extractTo($zip_path);
			$zip->close();
			echo 'Success in Unzipping...';
		} else {
			echo 'Error in Unzipping...';
		}

		\DB::unprepared(file_get_contents($sql_full_path));

		deleteFolder($sql_path);

		session()->flash('restore_message', 'Succesfully Restored');
		return redirect()->route('admin.backup.index');
	}


	public function deleteBakup($file)
	{
		ImageUploadHelper::delete('database/backup-db/'.$file);

		session()->flash('delete_message', 'Succesfully Deleted');
		return redirect()->route('admin.backup.index');
	}
}

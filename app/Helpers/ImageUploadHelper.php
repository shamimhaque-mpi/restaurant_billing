<?php

namespace App\Helpers;

use Image;
use Request;
use File;

class ImageUploadHelper
{

  /**
  * [upload description]
  * @param  [type] $image           [description]
  * @param  [type] $file            [description]
  * @param  [type] $slug            [description]
  * @param  [type] $target_location [description]
  * @return [type]                  [description]
  */
  public static function upload($image, $file, $name, $target_location, $width=500, $height=500)
  {
    if(Request::hasFile($image)){
      $filename = $name . '.' . $file->getClientOriginalExtension();
      $location = ($target_location.'/'.$filename);
      Image::make($file)->resize($width,$height)->save($location);
      return $filename;
    }
  }


  public static function update($image, $file, $name, $target_location, $old_location, $width=500, $height=500)
  {
    if(Request::hasFile($image)){
      $filename = $name. '.'.$file->getClientOriginalExtension();
      File::delete($old_location);
      $location = ($target_location.'/'.$filename);
      Image::make($file)->resize($width, $height)->save($location);
      return $filename;
    }
  }

  public static function delete($target_location)
  {
    if (File::exists($target_location)) {
      File::delete($target_location);
    }
  }


  public static function withApidelete($target_location)
  {
    @unlink($target_location);
  }


  public static function uploadWithResize($image, $file, $name, $target_location, $width="128", $hieght="128")
  {
    if(Request::hasFile($image)){
      $filename = $name . '.' . $file->getClientOriginalExtension();
      $location = ($target_location.'/'.$filename);
      Image::make($file)->resize($width,$hieght)->save($location);
      return $filename;
    }
  }


  public static function uploadWithOriginalSize($image, $file, $name, $target_location)
  {
    if(Request::hasFile($image)){
      $filename = $name . '.' . $file->getClientOriginalExtension();
      $location = ($target_location.'/'.$filename);
      Image::make($file)->save($location);
      return $filename;
    }
  }


  public static function updateWithResize($image, $file, $name, $target_location, $old_location, $width="128", $hieght="128")
  {
    if(Request::hasFile($image)){
      $filename = $name. '.'.$file->getClientOriginalExtension();
      File::delete($old_location);
      $location = ($target_location.'/'.$filename);
      Image::make($file)->resize($width, $hieght)->save($location);
      return $filename;
    }
  }


  public static function updateWithOriginalSize($image, $file, $name, $target_location, $old_location)
  {
    if(Request::hasFile($image)){
      $filename = $name. '.'.$file->getClientOriginalExtension();
      File::delete($old_location);
      $location = ($target_location.'/'.$filename);
      Image::make($file)->save($location);
      return $filename;
    }
  }

}

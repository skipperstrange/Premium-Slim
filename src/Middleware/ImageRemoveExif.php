<?php

namespace Premium\Middleware;

class ImageRemoveExif {

	protected $rawPath = UP_ONE.UP_ONE.RAW_IMG_PATH;
	protected $imgPath = UP_ONE.UP_ONE.LISTINGS_IMG_UPLOAD_PATH;

	public function __invoke($request, $response, $next) {

		$files    = $request->getUploadedFiles();
		$newfile  = $files['file'];
		$filename = $newfile->getClientFilename();
		$newfile->moveTo($this->rawPath.$filename);
		$png = $this->imgPath.substr($filename, 0, -4).".png";

		if ('image/jpeg' == $newfile->getClientMediaType()) {
			$_img = imagecreatefromjpeg($this->rawPath.$filename);
			echo 'This is'.imagepng($_img, $png);
		}

		$request->withAttribute('img_file', $filename);

		$response = $next($request, $response);

		return $response;
	}
}

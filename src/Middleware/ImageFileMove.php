<?php

namespace Premium\Middleware;

class ImageFileMove {
	public function __invoke($request, $response, $next) {

		$package = @$request->getUploadedFiles();

		$file      = $package['file'];
		$extension = pathinfo($file->getClientFilename(), PATHINFO_EXTENSION);

		if ($file->getError() === UPLOAD_ERR_OK) {
			$listing_id = $request->getAttribute('routeInfo')[2]['id'];
			$filename   = generateRandom($listing_id).'.'.$extension;
			$file->moveTo($filename);

			$request = $request->withAttribute('image', $filename);

		} else {
			return $response->withStatus(400)->withJson(['message' => 'Could not upload file']);
		}

		$response = $next($request, $response);

		return $response;
	}
}
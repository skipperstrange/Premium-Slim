<?php

namespace Premium\Middleware;

class FileFilter {

	protected $allowedFiles = ['image/jpeg', 'image/png'];

	public function __invoke($request, $response, $next) {

		$files   = $request->getUploadedFiles();
		$newfile = $files['file'];

		if (!in_array($newfile->getClientMediaType(), $this->allowedFiles)) {
			return $response->withStatus(415)->withJson(['filetype' => $newfile->getClientMediaType(), 'allowed files' => $this->allowedFiles]);
		}

		$response = $next($request, $response);

		return $response;
	}
}

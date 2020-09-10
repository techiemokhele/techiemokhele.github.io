<?php 

	class FormSanitizer {
		/*
			1. Clean user data - Sanitize
			2. Strip tag - remove <html> tags
			3. Convert to Uppercase
		*/
		public static function sanitizeFormString($inputText) {
			$inputText = strip_tags($inputText);
			$inputText = str_replace(" ", "", $inputText);
			$inputText = strtolower($inputText);
			$inputText = ucfirst($inputText);

			return $inputText;
		}

		public static function sanitizeFormUsername($inputText) {
			$inputText = strip_tags($inputText);
			$inputText = str_replace(" ", "", $inputText);

			return $inputText;
		}

		public static function sanitizeFormPassword($inputText) {
			$inputText = strip_tags($inputText);

			return $inputText;
		}

		public static function sanitizeFormEmail($inputText) {
			$inputText = strip_tags($inputText);
			$inputText = str_replace(" ", "", $inputText);

			return $inputText;
		}

	}

 ?>
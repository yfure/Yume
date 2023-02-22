<?php

/*
 * Translation file for EN-US language.
 *
 * @author Ari Setiawan (hxAri)
 * @create 27.01-2023
 * @update -
 *
 */
return(
	new Yume\Fure\Locale\Language\Language( "EN-US", [
		"Error" => [
			"AssertionError" => [
				"VALUE_ERROR" => "Invalid value for {} value must be {}, {+:ucfirst} given"
			],
			"BaseError" => [],
			"CacacheError" => [],
			"ClassError" => [
				"IMPLEMENTS_ERROR" => "Class {} must implement interface {}",
				"INSTANCE_ERROR" => "Unable to create new instance for class {}", 
				"NAME_ERROR" => "No class named {}"
			],
			"ClassImplementationError" => [
				"IMPLEMENTS_ERROR" => "^Error.ClassError.IMPLEMENTS_ERROR"
			],
			"ClassInstanceError" => [
				"INSTANCE_ERROR" => "^Error.ClassError.INSTANCE_ERROR"
			],
			"ClassNameError" => [ 
				"NAME_ERROR" => "^Error.ClassError.NAME_ERROR"
			],
			"ComponentError" => [
				"NAME_ERROR" => "No component named {}"
			],
			"DeprecatedError" => [
				"FUNCTION_ERROR" => "Function {} has been deprecated, use {} instead",
				"METHOD_ERROR" => "Method {} has been deprecated, use {} instead"
			],
			"FileError" => [
				"COPY_ERROR" => "Failed copy file from {} to {}",
				"FILE_ERROR" => "Target file {} is not file type",
				"MOVE_ERROR" => "Failed move file from {} to {}",
				"MODE_ERROR" => "Failed open file {}, invalid fopen mode for {}",
				"NAME_ERROR" => "The file name {} is invalid",
				"NOT_FOUND_ERROR" => "No such file {}",
				"OPEN_ERROR" => "Failed open file {}",
				"PATH_ERROR" => "Failed open file.{} because directory {} not found",
				"READ_ERROR" => "An error occurred while reading the contents of the file {}",
				"WRITE_ERROR" => "An error occurred while writing the contents of the file {}"
			],
			"FileNotFoundError" => [
				"NOT_FOUND_ERROR" => "^Error.FileError.NOT_FOUND_ERROR"
			],
			"HeaderError" => [],
			"HTTPError" => [],
			"IndexError" => [
				"INDEX_ERROR" => "^Error.LookupError.INDEX_ERROR"
			],
			"ImportError" => [
				"IMPORT_ERROR" => "^Error.ModuleError.IMPORT_ERROR",
			],
			"IOError" => [
				"PERMISSION_ERROR" => "Access denied for {}"
			],
			"JSONError" => [],
			"KeyError" => [
				"KEY_ERROR" => "^Error.LookupError.KEY_ERROR"
			],
			"LoggerError" => [
				"HANDLER_ERROR" => "Logger does not have any handler",
				"LEVEL_ERROR" => "{+:ucfirst} is an invalid log level"
			],
			"LogicError" => [],
			"LookupError" => [
				"INDEX_ERROR" => "Index {} out of range",
				"KEY_ERROR" => "Undefined key for {}"
			],
			"MessageError" => [],
			"ModuleError" => [
				"IMPORT_ERROR" => "Something wrong when import file {}",
				"NOT_FOUND_ERROR" => "No module named {}"
			],
			"ModuleNotFoundError" => [
				"NOT_FOUND_ERROR" => "^Error.ModuleError.NOT_FOUND_ERROR"
			],
			"PathError" => [
				"COPY_ERROR" => "Failed copy directory to {} from {}",
				"MOVE_ERROR" => "Failed move directory to {} from {}",
				"NOT_FOUND_ERROR" => "No such directory {}",
				"READ_ERROR" => "Cannot read anything in directory {}",
				"WRITE_ERROR" => "Could not write to file or directory in directory {}"
			],
			"PathNotFoundError" => [
				"NOT_FOUND_ERROR" => "^Error.PathError.NOT_FOUND_ERROR"
			],
			"PermissionError" => [
				"PERMISSION_ERROR" => "^Error.IOError.PERMISSION_ERROR",
				"READ_ERROR" => "Can't read {}",
				"WRITE_ERROR" => "Can't write {}"
			],
			"ReferenceError" => [],
			"RuntimeError" => [],
			"SecureError" => [],
			"ServicesError" => [
				"LOOKUP_ERROR" => "No service named {}",
				"NAME_ERROR" => "Service name must be type Object|String, {type(+):ucfirst} given",
				"OVERRIDE_ERROR" => "Can't override service {}"
			],
			"ServicesLookupError" => [
				"LOOKUP_ERROR" => "^Error.ServicesError.LOOKUP_ERROR"
			],
			"ServicesOverrideError" => [
				"OVERRIDE_ERROR" => "^Error.ServicesError.OVERRIDE_ERROR"
			],
			"StreamError" => [
				"STRINGIFY_ERROR" => "Failed parse Object Stream {} into string"
			],
			"SyntaxError" => [],
			"TemplateError" => [
				"CLOSING_ERROR" => "Invalid closing syntax \"{}\", unsupported multiple line for single line syntax",
				"INDENTATION_ERROR" => "Unexpected template indentation level for \"{}\"",
				"SYNTAX_ERROR" => "Invalid template syntax \"{}\"",
				"TOKEN_ERROR" => "Unexpected token @{}",
				"UNITIALIZED_TOKEN_ERROR" => "Syntax Template Class \"{}\" must initialize token name"
			],
			"TemplateClosingError" => [
				"CLOSING_ERROR" => "^Error.TemplateError.CLOSING_ERROR"
			],
			"TemplateIndentationError" => [
				"INDENTATION_ERROR" => "^Error.TemplateError.INDENTATION_ERROR"
			],
			"TemplateSyntaxError" => [
				"SYNTAX_ERROR" => "^Error.TemplateError.SYNTAX_ERROR"
			],
			"TemplateTokenError" => [
				"TOKEN_ERROR" => "^Error.TemplateError.TOKEN_ERROR"
			],
			"TemplateUninitializedTokenError" => [
				"UNITIALIZED_TOKEN_ERROR" => "^Error.TemplateError.UNITIALIZED_TOKEN_ERROR"
			],
			"TokenError" => [
				"ALGORITHM_ERROR" => "Unsupported algorithm {} for generate new application token",
				"LENGTH_ERROR" => "Length of application token must be equal with default minimum length token or biggest than default minimum token length, {} passed",
				"RUNTIME_ERROR" => "The application must set the token before running on the server"
			],
			"TriggerError" => [],
			"TypeError" => [],
			"ValueError" => [],
			"ViewError" => [
				"NOT_FOUND_ERROR" => "No such view file {}",
				"PARSE_ERROR" => "An error occurred while passing view {}"
			]
		]
	])
);

?>
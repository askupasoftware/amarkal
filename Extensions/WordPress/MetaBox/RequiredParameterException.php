<?php

namespace Amarkal\Extensions\WordPress\MetaBox;

/**
 * Exception thrown if a meta box or a meta box field is instantiated without 
 * a required parameter.
 * 
 * The required parameters are defined on a per-field basis.
 * 
 * @see FieldInterface::required_settings()
 */
class RequiredParameterException extends \RuntimeException { }

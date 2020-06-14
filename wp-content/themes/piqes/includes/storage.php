<?php
/**
 * Theme storage manipulations
 *
 * @package WordPress
 * @subpackage PIQES
 * @since PIQES 1.0
 */

// Disable direct call
if ( ! defined( 'ABSPATH' ) ) {
	exit; }

// Get theme variable
if ( ! function_exists( 'piqes_storage_get' ) ) {
	function piqes_storage_get( $var_name, $default = '' ) {
		global $PIQES_STORAGE;
		return isset( $PIQES_STORAGE[ $var_name ] ) ? $PIQES_STORAGE[ $var_name ] : $default;
	}
}

// Set theme variable
if ( ! function_exists( 'piqes_storage_set' ) ) {
	function piqes_storage_set( $var_name, $value ) {
		global $PIQES_STORAGE;
		$PIQES_STORAGE[ $var_name ] = $value;
	}
}

// Check if theme variable is empty
if ( ! function_exists( 'piqes_storage_empty' ) ) {
	function piqes_storage_empty( $var_name, $key = '', $key2 = '' ) {
		global $PIQES_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return empty( $PIQES_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return empty( $PIQES_STORAGE[ $var_name ][ $key ] );
		} else {
			return empty( $PIQES_STORAGE[ $var_name ] );
		}
	}
}

// Check if theme variable is set
if ( ! function_exists( 'piqes_storage_isset' ) ) {
	function piqes_storage_isset( $var_name, $key = '', $key2 = '' ) {
		global $PIQES_STORAGE;
		if ( ! empty( $key ) && ! empty( $key2 ) ) {
			return isset( $PIQES_STORAGE[ $var_name ][ $key ][ $key2 ] );
		} elseif ( ! empty( $key ) ) {
			return isset( $PIQES_STORAGE[ $var_name ][ $key ] );
		} else {
			return isset( $PIQES_STORAGE[ $var_name ] );
		}
	}
}

// Inc/Dec theme variable with specified value
if ( ! function_exists( 'piqes_storage_inc' ) ) {
	function piqes_storage_inc( $var_name, $value = 1 ) {
		global $PIQES_STORAGE;
		if ( empty( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = 0;
		}
		$PIQES_STORAGE[ $var_name ] += $value;
	}
}

// Concatenate theme variable with specified value
if ( ! function_exists( 'piqes_storage_concat' ) ) {
	function piqes_storage_concat( $var_name, $value ) {
		global $PIQES_STORAGE;
		if ( empty( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = '';
		}
		$PIQES_STORAGE[ $var_name ] .= $value;
	}
}

// Get array (one or two dim) element
if ( ! function_exists( 'piqes_storage_get_array' ) ) {
	function piqes_storage_get_array( $var_name, $key, $key2 = '', $default = '' ) {
		global $PIQES_STORAGE;
		if ( empty( $key2 ) ) {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $PIQES_STORAGE[ $var_name ][ $key ] ) ? $PIQES_STORAGE[ $var_name ][ $key ] : $default;
		} else {
			return ! empty( $var_name ) && ! empty( $key ) && isset( $PIQES_STORAGE[ $var_name ][ $key ][ $key2 ] ) ? $PIQES_STORAGE[ $var_name ][ $key ][ $key2 ] : $default;
		}
	}
}

// Set array element
if ( ! function_exists( 'piqes_storage_set_array' ) ) {
	function piqes_storage_set_array( $var_name, $key, $value ) {
		global $PIQES_STORAGE;
		if ( ! isset( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$PIQES_STORAGE[ $var_name ][] = $value;
		} else {
			$PIQES_STORAGE[ $var_name ][ $key ] = $value;
		}
	}
}

// Set two-dim array element
if ( ! function_exists( 'piqes_storage_set_array2' ) ) {
	function piqes_storage_set_array2( $var_name, $key, $key2, $value ) {
		global $PIQES_STORAGE;
		if ( ! isset( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = array();
		}
		if ( ! isset( $PIQES_STORAGE[ $var_name ][ $key ] ) ) {
			$PIQES_STORAGE[ $var_name ][ $key ] = array();
		}
		if ( '' === $key2 ) {
			$PIQES_STORAGE[ $var_name ][ $key ][] = $value;
		} else {
			$PIQES_STORAGE[ $var_name ][ $key ][ $key2 ] = $value;
		}
	}
}

// Merge array elements
if ( ! function_exists( 'piqes_storage_merge_array' ) ) {
	function piqes_storage_merge_array( $var_name, $key, $value ) {
		global $PIQES_STORAGE;
		if ( ! isset( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			$PIQES_STORAGE[ $var_name ] = array_merge( $PIQES_STORAGE[ $var_name ], $value );
		} else {
			$PIQES_STORAGE[ $var_name ][ $key ] = array_merge( $PIQES_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Add array element after the key
if ( ! function_exists( 'piqes_storage_set_array_after' ) ) {
	function piqes_storage_set_array_after( $var_name, $after, $key, $value = '' ) {
		global $PIQES_STORAGE;
		if ( ! isset( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			piqes_array_insert_after( $PIQES_STORAGE[ $var_name ], $after, $key );
		} else {
			piqes_array_insert_after( $PIQES_STORAGE[ $var_name ], $after, array( $key => $value ) );
		}
	}
}

// Add array element before the key
if ( ! function_exists( 'piqes_storage_set_array_before' ) ) {
	function piqes_storage_set_array_before( $var_name, $before, $key, $value = '' ) {
		global $PIQES_STORAGE;
		if ( ! isset( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = array();
		}
		if ( is_array( $key ) ) {
			piqes_array_insert_before( $PIQES_STORAGE[ $var_name ], $before, $key );
		} else {
			piqes_array_insert_before( $PIQES_STORAGE[ $var_name ], $before, array( $key => $value ) );
		}
	}
}

// Push element into array
if ( ! function_exists( 'piqes_storage_push_array' ) ) {
	function piqes_storage_push_array( $var_name, $key, $value ) {
		global $PIQES_STORAGE;
		if ( ! isset( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = array();
		}
		if ( '' === $key ) {
			array_push( $PIQES_STORAGE[ $var_name ], $value );
		} else {
			if ( ! isset( $PIQES_STORAGE[ $var_name ][ $key ] ) ) {
				$PIQES_STORAGE[ $var_name ][ $key ] = array();
			}
			array_push( $PIQES_STORAGE[ $var_name ][ $key ], $value );
		}
	}
}

// Pop element from array
if ( ! function_exists( 'piqes_storage_pop_array' ) ) {
	function piqes_storage_pop_array( $var_name, $key = '', $defa = '' ) {
		global $PIQES_STORAGE;
		$rez = $defa;
		if ( '' === $key ) {
			if ( isset( $PIQES_STORAGE[ $var_name ] ) && is_array( $PIQES_STORAGE[ $var_name ] ) && count( $PIQES_STORAGE[ $var_name ] ) > 0 ) {
				$rez = array_pop( $PIQES_STORAGE[ $var_name ] );
			}
		} else {
			if ( isset( $PIQES_STORAGE[ $var_name ][ $key ] ) && is_array( $PIQES_STORAGE[ $var_name ][ $key ] ) && count( $PIQES_STORAGE[ $var_name ][ $key ] ) > 0 ) {
				$rez = array_pop( $PIQES_STORAGE[ $var_name ][ $key ] );
			}
		}
		return $rez;
	}
}

// Inc/Dec array element with specified value
if ( ! function_exists( 'piqes_storage_inc_array' ) ) {
	function piqes_storage_inc_array( $var_name, $key, $value = 1 ) {
		global $PIQES_STORAGE;
		if ( ! isset( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = array();
		}
		if ( empty( $PIQES_STORAGE[ $var_name ][ $key ] ) ) {
			$PIQES_STORAGE[ $var_name ][ $key ] = 0;
		}
		$PIQES_STORAGE[ $var_name ][ $key ] += $value;
	}
}

// Concatenate array element with specified value
if ( ! function_exists( 'piqes_storage_concat_array' ) ) {
	function piqes_storage_concat_array( $var_name, $key, $value ) {
		global $PIQES_STORAGE;
		if ( ! isset( $PIQES_STORAGE[ $var_name ] ) ) {
			$PIQES_STORAGE[ $var_name ] = array();
		}
		if ( empty( $PIQES_STORAGE[ $var_name ][ $key ] ) ) {
			$PIQES_STORAGE[ $var_name ][ $key ] = '';
		}
		$PIQES_STORAGE[ $var_name ][ $key ] .= $value;
	}
}

// Call object's method
if ( ! function_exists( 'piqes_storage_call_obj_method' ) ) {
	function piqes_storage_call_obj_method( $var_name, $method, $param = null ) {
		global $PIQES_STORAGE;
		if ( null === $param ) {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $PIQES_STORAGE[ $var_name ] ) ? $PIQES_STORAGE[ $var_name ]->$method() : '';
		} else {
			return ! empty( $var_name ) && ! empty( $method ) && isset( $PIQES_STORAGE[ $var_name ] ) ? $PIQES_STORAGE[ $var_name ]->$method( $param ) : '';
		}
	}
}

// Get object's property
if ( ! function_exists( 'piqes_storage_get_obj_property' ) ) {
	function piqes_storage_get_obj_property( $var_name, $prop, $default = '' ) {
		global $PIQES_STORAGE;
		return ! empty( $var_name ) && ! empty( $prop ) && isset( $PIQES_STORAGE[ $var_name ]->$prop ) ? $PIQES_STORAGE[ $var_name ]->$prop : $default;
	}
}

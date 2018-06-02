<<<<<<< HEAD
define( [
	"../var/document"
], function( document ) {
	"use strict";

	function DOMEval( code, doc ) {
		doc = doc || document;

		var script = doc.createElement( "script" );

		script.text = code;
		doc.head.appendChild( script ).parentNode.removeChild( script );
	}

	return DOMEval;
} );
=======
define( [
	"../var/document"
], function( document ) {
	"use strict";

	function DOMEval( code, doc ) {
		doc = doc || document;

		var script = doc.createElement( "script" );

		script.text = code;
		doc.head.appendChild( script ).parentNode.removeChild( script );
	}

	return DOMEval;
} );
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de

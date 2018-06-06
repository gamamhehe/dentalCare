<<<<<<< HEAD
import { isValid as _isValid } from '../create/valid';
import extend from '../utils/extend';
import getParsingFlags from '../create/parsing-flags';

export function isValid () {
    return _isValid(this);
}

export function parsingFlags () {
    return extend({}, getParsingFlags(this));
}

export function invalidAt () {
    return getParsingFlags(this).overflow;
}
=======
import { isValid as _isValid } from '../create/valid';
import extend from '../utils/extend';
import getParsingFlags from '../create/parsing-flags';

export function isValid () {
    return _isValid(this);
}

export function parsingFlags () {
    return extend({}, getParsingFlags(this));
}

export function invalidAt () {
    return getParsingFlags(this).overflow;
}
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de

<<<<<<< HEAD
module('Methods (jQuery)', {
    setup: function(){
        this.$inputs = $('<input><input>')
            .datepicker()
            .appendTo('#qunit-fixture');
    },
    teardown: function(){
        this.$inputs.each(function(){
            $.data(this, 'datepicker').picker.remove();
        });
    }
});

test('Methods', function(){
    [
        'show',
        'hide',
        'setValue',
        'place'
    ].forEach($.proxy(function(index, value){
        var returnedObject = this.$inputs.datepicker(value);

        strictEqual(returnedObject, this.$inputs, "is jQuery element");
        strictEqual(returnedObject.length, 2, "correct length of jQuery elements");
    }, this));
});
=======
module('Methods (jQuery)', {
    setup: function(){
        this.$inputs = $('<input><input>')
            .datepicker()
            .appendTo('#qunit-fixture');
    },
    teardown: function(){
        this.$inputs.each(function(){
            $.data(this, 'datepicker').picker.remove();
        });
    }
});

test('Methods', function(){
    [
        'show',
        'hide',
        'setValue',
        'place'
    ].forEach($.proxy(function(index, value){
        var returnedObject = this.$inputs.datepicker(value);

        strictEqual(returnedObject, this.$inputs, "is jQuery element");
        strictEqual(returnedObject.length, 2, "correct length of jQuery elements");
    }, this));
});
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de

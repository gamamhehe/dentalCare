<<<<<<< HEAD
define(function () {
  // Latvian
  function ending (count, eleven, singular, other) {
    if (count === 11) {
      return eleven;
    }

    if (count % 10 === 1) {
      return singular;
    }

    return other;
  }

  return {
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      var message = 'Lūdzu ievadiet par  ' + overChars;

      message += ' simbol' + ending(overChars, 'iem', 'u', 'iem');

      return message + ' mazāk';
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = 'Lūdzu ievadiet vēl ' + remainingChars;

      message += ' simbol' + ending(remainingChars, 'us', 'u', 'us');

      return message;
    },
    loadingMore: function () {
      return 'Datu ielāde…';
    },
    maximumSelected: function (args) {
      var message = 'Jūs varat izvēlēties ne vairāk kā ' + args.maximum;

      message += ' element' + ending(args.maximum, 'us', 'u', 'us');

      return message;
    },
    noResults: function () {
      return 'Sakritību nav';
    },
    searching: function () {
      return 'Meklēšana…';
    }
  };
});
=======
define(function () {
  // Latvian
  function ending (count, eleven, singular, other) {
    if (count === 11) {
      return eleven;
    }

    if (count % 10 === 1) {
      return singular;
    }

    return other;
  }

  return {
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      var message = 'Lūdzu ievadiet par  ' + overChars;

      message += ' simbol' + ending(overChars, 'iem', 'u', 'iem');

      return message + ' mazāk';
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = 'Lūdzu ievadiet vēl ' + remainingChars;

      message += ' simbol' + ending(remainingChars, 'us', 'u', 'us');

      return message;
    },
    loadingMore: function () {
      return 'Datu ielāde…';
    },
    maximumSelected: function (args) {
      var message = 'Jūs varat izvēlēties ne vairāk kā ' + args.maximum;

      message += ' element' + ending(args.maximum, 'us', 'u', 'us');

      return message;
    },
    noResults: function () {
      return 'Sakritību nav';
    },
    searching: function () {
      return 'Meklēšana…';
    }
  };
});
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de

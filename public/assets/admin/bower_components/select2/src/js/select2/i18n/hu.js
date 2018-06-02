<<<<<<< HEAD
define(function () {
  // Hungarian
  return {
    errorLoading: function () {
      return 'Az eredmények betöltése nem sikerült.';
    },
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      return 'Túl hosszú. ' + overChars + ' karakterrel több, mint kellene.';
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      return 'Túl rövid. Még ' + remainingChars + ' karakter hiányzik.';
    },
    loadingMore: function () {
      return 'Töltés…';
    },
    maximumSelected: function (args) {
      return 'Csak ' + args.maximum + ' elemet lehet kiválasztani.';
    },
    noResults: function () {
      return 'Nincs találat.';
    },
    searching: function () {
      return 'Keresés…';
    }
  };
});
=======
define(function () {
  // Hungarian
  return {
    errorLoading: function () {
      return 'Az eredmények betöltése nem sikerült.';
    },
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      return 'Túl hosszú. ' + overChars + ' karakterrel több, mint kellene.';
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      return 'Túl rövid. Még ' + remainingChars + ' karakter hiányzik.';
    },
    loadingMore: function () {
      return 'Töltés…';
    },
    maximumSelected: function (args) {
      return 'Csak ' + args.maximum + ' elemet lehet kiválasztani.';
    },
    noResults: function () {
      return 'Nincs találat.';
    },
    searching: function () {
      return 'Keresés…';
    }
  };
});
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de

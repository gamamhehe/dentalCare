<<<<<<< HEAD
define(function () {
  // Spanish
  return {
    errorLoading: function () {
      return 'La carga falló';
    },
    inputTooLong: function (args) {
      var remainingChars = args.input.length - args.maximum;

      var message = 'Por favor, elimine ' + remainingChars + ' car';

      if (remainingChars == 1) {
        message += 'ácter';
      } else {
        message += 'acteres';
      }

      return message;
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = 'Por favor, introduzca ' + remainingChars + ' car';

      if (remainingChars == 1) {
        message += 'ácter';
      } else {
        message += 'acteres';
      }

      return message;
    },
    loadingMore: function () {
      return 'Cargando más resultados…';
    },
    maximumSelected: function (args) {
      var message = 'Sólo puede seleccionar ' + args.maximum + ' elemento';

      if (args.maximum != 1) {
        message += 's';
      }

      return message;
    },
    noResults: function () {
      return 'No se encontraron resultados';
    },
    searching: function () {
      return 'Buscando…';
    }
  };
});
=======
define(function () {
  // Spanish
  return {
    errorLoading: function () {
      return 'La carga falló';
    },
    inputTooLong: function (args) {
      var remainingChars = args.input.length - args.maximum;

      var message = 'Por favor, elimine ' + remainingChars + ' car';

      if (remainingChars == 1) {
        message += 'ácter';
      } else {
        message += 'acteres';
      }

      return message;
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = 'Por favor, introduzca ' + remainingChars + ' car';

      if (remainingChars == 1) {
        message += 'ácter';
      } else {
        message += 'acteres';
      }

      return message;
    },
    loadingMore: function () {
      return 'Cargando más resultados…';
    },
    maximumSelected: function (args) {
      var message = 'Sólo puede seleccionar ' + args.maximum + ' elemento';

      if (args.maximum != 1) {
        message += 's';
      }

      return message;
    },
    noResults: function () {
      return 'No se encontraron resultados';
    },
    searching: function () {
      return 'Buscando…';
    }
  };
});
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de

<<<<<<< HEAD
define(function () {
  // Japanese
  return {
    errorLoading: function () {
      return '結果が読み込まれませんでした';
    },
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      var message = overChars + ' 文字を削除してください';

      return message;
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = '少なくとも ' + remainingChars + ' 文字を入力してください';

      return message;
    },
    loadingMore: function () {
      return '読み込み中…';
    },
    maximumSelected: function (args) {
      var message = args.maximum + ' 件しか選択できません';

      return message;
    },
    noResults: function () {
      return '対象が見つかりません';
    },
    searching: function () {
      return '検索しています…';
    }
  };
});
=======
define(function () {
  // Japanese
  return {
    errorLoading: function () {
      return '結果が読み込まれませんでした';
    },
    inputTooLong: function (args) {
      var overChars = args.input.length - args.maximum;

      var message = overChars + ' 文字を削除してください';

      return message;
    },
    inputTooShort: function (args) {
      var remainingChars = args.minimum - args.input.length;

      var message = '少なくとも ' + remainingChars + ' 文字を入力してください';

      return message;
    },
    loadingMore: function () {
      return '読み込み中…';
    },
    maximumSelected: function (args) {
      var message = args.maximum + ' 件しか選択できません';

      return message;
    },
    noResults: function () {
      return '対象が見つかりません';
    },
    searching: function () {
      return '検索しています…';
    }
  };
});
>>>>>>> 6647e7f68513f34b86ec6c59d3a99f618da1b2de

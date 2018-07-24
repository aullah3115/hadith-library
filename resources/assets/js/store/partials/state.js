import colors from 'vuetify/es5/util/colors';
import locales from '../../language/locales';

export default {
  languages: null,
  drawer: false,
  search_results: null, //TODO delete one of these two
  search_results1: null,
  theme: {
    primary: colors.red.darken1,
    secondary: colors.grey.darken1,
    admin: colors.green.darken1,
  },
  primary: [
    {text: 'blue', value: colors.blue.darken2},
    {text: 'lime', value: colors.lime.base},
    {text: 'red', value: colors.red.darken1},
    {text: 'purple', value: colors.purple.darken2},
    {text: 'beautiful purple', value: colors.purple.accent1},
    {text: 'green', value: colors.green.base},
    {text: 'light green', value: colors.lightGreen.accent3},
    {text: 'yellow', value: colors.yellow.darken3},
    {text: 'beautiful pink', value: colors.pink.accent1},
    {text: 'indigo', value: colors.indigo.accent1},
    {text: 'beautiful gold', value: colors.amber.darken1},
  ],
  locales,
  search_terms: [],
}

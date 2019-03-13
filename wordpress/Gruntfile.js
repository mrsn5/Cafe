/**
 * Created by San on 13.03.2019.
 */
module.exports = function(grunt) {
    //Налаштування збірки Grunt
    var config = {
        //Інформацію про проект з файлу package.json
        pkg: grunt.file.readJSON('package.json'),

        //Конфігурація для модуля browserify (перетворює require(..) в код
        browserify:     {
            //Загальні налаштування (grunt-browserify)
            options:      {

                //brfs замість fs.readFileSync вставляє вміст файлу
                transform:  [ require('brfs') ],
                browserifyOptions: {
                    //Папка з корнем джерельних кодів javascript
                    basedir: "wp-content/themes/cafe_theme/js/"
                }
            },

            //Збірка з назвою personnel
            personnel: {
                src:        'wp-content/themes/cafe_theme/js/personnel.js',
                dest:       'wp-content/themes/cafe_theme/js/compiled/personnel.js'
            }
        }
    };

    //Налаштування відстежування змін в проекті
    var watchDebug = {
        options: {
            'no-beep': true
        },
        //Назва завдання будь-яка
        scripts: {
            //На зміни в яких файлах реагувати
            files: ['wp-content/themes/cafe_theme/js/*.js', 'wp-content/themes/cafe_theme/templates/*.ejs'],
            //Які завдання виконувати під час зміни в файлах
            tasks: ['browserify:personnel']
        }
    };


    //Ініціалузвати Grunt
    config.watch = watchDebug;
    grunt.initConfig(config);

    //Сказати які модулі необхідно виокристовувати
    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-contrib-watch');


    //Список завданнь по замовчування
    grunt.registerTask('default',
        [
            'browserify:personnel',
            //Інші завдання які необхідно виконати
        ]
    );

};
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
                    basedir: "js/"
                }
            },

            //Збірка з назвою personnel
            personnel: {
                src:        'js/personnel.js',
                dest:       'js/compiled/personnel.js'
            },

            deliverers: {
                src:        'js/deliverer.js',
                dest:       'js/compiled/deliverer.js'
            },

            menu: {
                src:        'js/menu.js',
                dest:       'js/compiled/menu.js'
            },

            category: {
                src:        'js/category.js',
                dest:       'js/compiled/category.js'
            },

            statistic: {
                src:        'js/statistics.js',
                dest:       'js/compiled/statistics.js'
            },

            history: {
                src:        'js/history.js',
                dest:       'js/compiled/history.js'
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
            files: ['js/*.js', 'templates/*.ejs'],
            //Які завдання виконувати під час зміни в файлах
            tasks: ['browserify:personnel','browserify:deliverers', 'browserify:menu', 'browserify:category', 'browserify:statistic', 'browserify:history' ]
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
            'browserify:deliverers',
            'browserify:menu',
            'browserify:category',
            'browserify:statistic',
            'browserify:history'
            //Інші завдання які необхідно виконати
        ]
    );

};
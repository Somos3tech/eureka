let gulp = require("gulp");
let sass = require("gulp-sass");
let rename = require("gulp-rename");
var browserSync = require("browser-sync").create();

sass.compiler = require("node-sass");

gulp.task("styles", () => {
    return gulp
        .src("app.scss", { allowEmpty: true })
        .pipe(sass())
        .pipe(rename("app.css"))
        .pipe(gulp.dest("public"));
});

gulp.task("assets", () => {
    gulp.src("assets/*").pipe(gulp.dest("public"));
});

gulp.task("watch", () => {
    gulp.watch("./app.scss", gulp.series("styles"));
    gulp.watch("./asset/*", gulp.series("assets"));
});

// Static Server + watching scss/html files
gulp.task("browser-sync", function () {
    browserSync.init({
        port: 8080,
        proxy: "domicompras-dev",
    });
});

gulp.task(
    "default",
    gulp.series("styles"),
    gulp.series("assets"),
    gulp.series("browser-sync"),
    gulp.series("watch")
);

import path from 'path'
import fs from 'fs'
import { glob } from 'glob'
import { src, dest, watch, series } from 'gulp'
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import terser from 'gulp-terser'
import sharp from 'sharp'
import postcss from 'gulp-postcss';
import concat from 'gulp-concat';
import sourcemaps from 'gulp-sourcemaps';
import autoprefixer from 'autoprefixer';
import rename from 'gulp-rename';
import cssnanoPlugin from 'cssnano';
const plugins = [autoprefixer(), cssnanoPlugin];

const sass = gulpSass(dartSass)

const paths = {
    scss: 'src/scss/**/*.scss',
    js: 'src/js/**/*.js'
}

function buildStyles() {
    return src('./src/scss/app.scss', { sourcemaps: true })
        .pipe(sass().on('error', sass.logError))
        .pipe(postcss(plugins))
        .pipe(dest('./public/build/css/', { sourcemaps: '.' }));
}

function buildJS() {
    return src(paths.js, { base: './src' }) // keeps the same structure of the ./src folder
        .pipe(sourcemaps.init())
        .pipe(terser()) //uglify the code //comment to use the debugger
        .pipe(rename({ suffix: '.min' })) // add .min
        .pipe(sourcemaps.write('.')) // writte sourcemaps
        .pipe(dest('./public/build/')); // final folder
}

//Use version below to concat everything in a single file: 

// function buildJS() {
//     return src(paths.js)
//         .pipe(sourcemaps.init())
//         .pipe(concat('app.js'))
//         .pipe(terser())
//         .pipe(rename({ suffix: '.min', dirname: 'js' }))
//         .pipe(sourcemaps.write('.'))
//         .pipe(dest('./public/build/'))

// }

export async function images(done) {
    const srcDir = './src/img';
    const buildDir = './public/build/img';
    const images = await glob('./src/img/**/*')

    images.forEach(file => {
        const relativePath = path.relative(srcDir, path.dirname(file));
        const outputSubDir = path.join(buildDir, relativePath);
        processImages(file, outputSubDir);
    });
    done();
}
function processImages(file, outputSubDir) {
    if (!fs.existsSync(outputSubDir)) {
        fs.mkdirSync(outputSubDir, { recursive: true })
    }
    const baseName = path.basename(file, path.extname(file))
    const extName = path.extname(file)

    if (extName.toLowerCase() === '.svg') {
        // If it's an SVG file, move it to the output directory
        const outputFile = path.join(outputSubDir, `${baseName}${extName}`);
        fs.copyFileSync(file, outputFile);
    } else {
        // For other image formats, process them with sharp
        const outputFile = path.join(outputSubDir, `${baseName}${extName}`);
        const outputFileWebp = path.join(outputSubDir, `${baseName}.webp`);
        const outputFileAvif = path.join(outputSubDir, `${baseName}.avif`);
        const options = { quality: 80 };

        sharp(file).jpeg(options).toFile(outputFile);
        sharp(file).webp(options).toFile(outputFileWebp);
        sharp(file).avif().toFile(outputFileAvif);
    }
}

export function dev() {
    watch(paths.scss, buildStyles);
    watch(paths.js, buildJS);
    watch('src/img/**/*.{png,jpg}', images)
}

export default series(buildJS, buildStyles, images, dev)
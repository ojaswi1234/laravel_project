const fs = require('fs');
const pkg = JSON.parse(fs.readFileSync('package.json', 'utf8'));
pkg.scripts.start = 'concurrently "php artisan serve --host=0.0.0.0 --port=8000" "php artisan queue:work" "php artisan reverb:start --host=0.0.0.0 --port=8080" "npm run dev -- --host 0.0.0.0"';
fs.writeFileSync('package.json', JSON.stringify(pkg, null, 4));

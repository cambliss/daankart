current_branch=$(git branch --show-current)
git pull origin $current_branch
composer install --no-interaction --prefer-dist --optimize-autoloader 
php artisan optimize:clear
echo $(date '+%Y-%m-%d %H:%M:%S')
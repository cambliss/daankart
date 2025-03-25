current_branch=$(git branch --show-current)
git pull origin $current_branch
php artisan optimize:clear
echo $(date '+%Y-%m-%d %H:%M:%S')
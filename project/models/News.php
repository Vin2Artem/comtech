<?php
namespace Project\Models;

use \Core\Model;

class News extends Model
{
    public $id;
    public $title;
    public $description;
    public $date;
    public $groupIds;

    protected function __construct(int $id, string $title, string $description, $date, array $groupIds)
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->groupIds = $groupIds;
    }

    private static function getGroups(int $news_id) {
        $groups_db = self::findManySafe('SELECT `group` FROM news_group where news = ?', 'i', [$news_id]);
        $groups = [];
        if ($groups_db === NULL) {
            return $groups;
        }
        if ($groups_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        foreach ($groups_db as $group_db) {
            $groups[] = $group_db['group'];
        }
        return $groups;
    }
    
    public static function getAll() {
        $news_db = self::findManySafe('SELECT * FROM news ORDER BY date DESC');
        if ($news_db === NULL) {
            return "Новости отсутствуют";
        }
        if ($news_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }

        $news = [];
        foreach ($news_db as $new_db) {
            $news[] = new News(
                $new_db['id'],
                $new_db['title'],
                $new_db['description'],
                $new_db['date'],
                self::getGroups($new_db['id'])
            );
        }
        return $news;
    }

    public static function getById(int $id)
    {
        $new_db = self::findOneSafe('SELECT * FROM news WHERE id = ?', 'i', [$id]);
        if ($new_db === NULL) {
            return "Новость с идентификатором $id не найдена";
        }
        if ($new_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }

        return new News(
            $new_db['id'],
            $new_db['title'],
            $new_db['description'],
            $new_db['date'],
            self::getGroups($new_db['id'])
        );
    }

    public static function addNews(string $title, string $description, $date, array $groupIds) {
        // #
    }

    public function editNews(string $title, string $description, array $groupIds) {
        // #
    }

    public function deleteNews() {
        // #
    }
}
?>
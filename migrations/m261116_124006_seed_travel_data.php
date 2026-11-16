<?php

use yii\db\Migration;

class m261116_124006_seed_travel_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%category}}', ['title', 'description'], [
            ['Європа та міста', 'Гіди по європейських столицях, маршрути вихідного дня та архітектура'],
            ['Гори та трекінг', 'Походи в Карпати, Альпи, спорядження та безпека на маршрутах'],
            ['Бюджетні подорожі', 'Лоукостери, лайфхаки з житлом та планування поїздок без переплат'],
            ['Гастротуризм', 'Національні кухні світу, вулична їжа та автентичні заклади'],
        ]);

        $this->batchInsert('{{%tag}}', ['title'], [
            ['Карпати'],
            ['Європа'],
            ['Лайфхаки'],
            ['Бюджет'],
            ['Маршрути'],
            ['Авіаквитки'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m261116_124006_seed_travel_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m261116_124006_seed_travel_data cannot be reverted.\n";

        return false;
    }
    */
}

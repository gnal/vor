<?php

namespace Vor\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ImportDataCommand extends ContainerAwareCommand
{
    private $dbh;
    private $output;

    protected function configure()
    {
        $this
            ->setName('vor:import')
            ->setDescription('import data from old database')
        ;
        $this->dbh = new \PDO('mysql:host=localhost;dbname=dev_vor1945_old', 'root', '123456');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        //create base categories
        $m = $this->getContainer()->get('msi_store.product_category_manager');
        $root = $m->create();
        $root->createTranslation('en');
        $root->getTranslation()->setName('Root');
        $root->getTranslation()->setPublished(true);
        $m->update($root);

        $m = $this->getContainer()->get('msi_store.product_category_manager');
        $object = $m->create();
        $object->createTranslation('en');
        $object->getTranslation()->setName('Printed Materials');
        $object->getTranslation()->setPublished(true);
        $object->setParent($root);
        $m->update($object);
        $this->printed_id = $object->getId();
        $object = $m->create();
        $object->createTranslation('en');
        $object->getTranslation()->setName('Memorabilia');
        $object->getTranslation()->setPublished(true);
        $object->setParent($root);
        $m->update($object);
        $this->memo_id = $object->getId();
        $object = $m->create();
        $object->createTranslation('en');
        $object->getTranslation()->setName('Archives');
        $object->getTranslation()->setPublished(true);
        $object->setParent($root);
        $m->update($object);
        $this->archive_id = $object->getId();

        $this->importCategories();
        // $this->importBooks();
    }

    protected function query($sql)
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $results = $sth->fetchAll(\PDO::FETCH_OBJ);

        return $results;
    }

    protected function importCategories()
    {
        $rows = $this->query('SELECT * FROM books_categories');
        $m = $this->getContainer()->get('msi_store.product_category_manager');

        $i = 0;
        foreach ($rows as $row) {
            $object = $m->create();
            $object->createTranslation('en');

            $object->getTranslation()->setName(trim($row->name));
            $object->getTranslation()->setPublished(true);
            $object->setParent($this->getContainer()->get('msi_store.product_category_manager')->find(['a.id' => $this->printed_id]));

            $m->update($object);

            $this->output->writeln('<question>IMPORTING book category with id '.$row->id.'</question>');
        }
    }

    protected function importBooks()
    {
        $rows = $this->query('SELECT * FROM books');
        $m = $this->getContainer()->get('msi_store.product_manager');

        $i = 0;
        foreach ($rows as $row) {
            $object = $m->create();
            $object->createTranslation('en');

            $object->setPrice(trim($row->price));
            $object->getTranslation()->setName(trim($row->title));
            $object->getTranslation()->setContent('<p>'.trim($row->description).'</p>');
            $object->getTranslation()->setPublished(true);

            $m->update($object);

            $this->importBooksPhotos($row->id, $object);

            $this->output->writeln('<question>IMPORTING book with id '.$row->id.'</question>');

            $i++;
            if ($i > 30) {
                break;
            }
        }
    }

    protected function importBooksPhotos($oldbookid, $product)
    {
        $rows = $this->query('SELECT * FROM books_photos WHERE item_id = '.$oldbookid);
        $m = $this->getContainer()->get('msi_store.product_image_manager');

        $i = 0;
        foreach ($rows as $row) {
            $object = $m->create();

            $object->setFilename($row->filename);
            $object->setProduct($product);

            $m->update($object);

            $i++;
        }
    }
}

<?php
namespace Test\InterviewBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class TestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('test:command')
            ->setDescription('Demande 15')
            ->addArgument(
                'id'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('This is a test. Do you want to continue (y/N)?', false);

        if (!$helper->ask($input, $output, $question)) {
            $output->writeln("Nothing done. Exiting...");
            return;
        }
        $id= $input->getArgument('id');

        $container = $this->getContainer();

        $service = $container->get('testinterview.biosservice');
        $result = $service->getById($id);

        $text = $result->getContent() === 'true' ?'document exists' : 'document doesnt exist';

        $output->writeln($text);
    }
}
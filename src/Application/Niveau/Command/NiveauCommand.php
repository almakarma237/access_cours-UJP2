<?php


namespace App\Application\Niveau\Command;


use App\Application\Niveau\Dto\NiveauDto;
use App\Domain\Niveau\Entity\Niveau;
use Doctrine\ORM\EntityManagerInterface;

class NiveauCommand
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param NiveauDto $niveauDto
     * @return void
     */
    public function create(NiveauDto $niveauDto) : void
    {
        $niveau = new Niveau();

        $niveau->setNom($niveauDto->nom)
            ->setAlias($niveauDto->alias);

        $this->manager->persist($niveau);
        $this->manager->flush();
    }

    /**
     * @param Niveau $niveau
     * @return void
     */
    public function delete(Niveau $niveau) : void
    {
        $this->manager->remove($niveau);
        $this->manager->flush();
    }

    /**
     * @param NiveauDto $niveauDto
     */
    public function update(NiveauDto $niveauDto)
    {
        $repo = $this->manager->getRepository(Niveau::class);
        $niveau = $repo->findOneBy(["id"=>$niveauDto->id]);

        $niveau->setNom($niveauDto->nom)
            ->setAlias($niveauDto->alias);

        $this->manager->flush();
    }
}
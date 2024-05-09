<?php

namespace App\Controller;

use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/view', name: 'library_view_all')]
    public function viewAllLibrary(
        LibraryRepository $libraryRepository
    ): Response {
        $library = $libraryRepository->findAll();

        $data = [
            'library' => $library
        ];

        return $this->render('library/view.html.twig', $data);
    }

    #[Route('/library/one/{id}/{title}/{isbn}/{author}/{image}', name: 'library_view_one')]
    public function viewOne(
        LibraryRepository $libraryRepository,
        int $id,
        string $title,
        string $isbn,
        string $author,
        string $image
    ): Response {
        $data = [
            'id' => $id,
            'title' => $title,
            'isbn' => $isbn,
            'author' => $author,
            'image' => $image
        ];

        return $this->render('library/view-one.html.twig', $data);
    }

    #[Route('/library/add', name: 'library_add')]
    public function addToLibrary(
        LibraryRepository $libraryRepository
    ): Response {
        $library = $libraryRepository->findAll();

        $data = [
            'library' => $library
        ];

        return $this->render('library/add.html.twig', $data);
    }

    #[Route('/library/add/post', name: 'library_add_post', methods: ['POST'])]
    public function postToLibrary(
        Request $request,
        ManagerRegistry $doctrine,
        LibraryRepository $libraryRepository
    ): Response {
        $entityManager = $doctrine->getManager();

        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $image = $request->request->get('image');

        $library = new Library();
        $library->setTitle($title);
        $library->setIsbn($isbn);
        $library->setAuthor($author);
        $library->setImage($image);

        $entityManager->persist($library);

        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/update/{id}/{title}/{isbn}/{author}/{image}', name: 'library_update')]
    public function updateLibrary(
        LibraryRepository $libraryRepository,
        int $id,
        string $title,
        string $isbn,
        string $author,
        string $image
    ): Response {
        $data = [
            'id' => $id,
            'title' => $title,
            'isbn' => $isbn,
            'author' => $author,
            'image' => $image
        ];

        return $this->render('library/update.html.twig', $data);
    }

    #[Route('/library/update/post', name: 'library_update_post', methods: ['POST'])]
    public function postUpdateLibrary(
        Request $request,
        ManagerRegistry $doctrine,
        LibraryRepository $libraryRepository
    ): Response {
        $entityManager = $doctrine->getManager();

        $id = $request->request->get('id');
        $title = $request->request->get('title');
        $isbn = $request->request->get('isbn');
        $author = $request->request->get('author');
        $image = $request->request->get('image');

        $book = $entityManager->getRepository(Library::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $book->setTitle($title);
        $book->setIsbn($isbn);
        $book->setAuthor($author);
        $book->setImage($image);

        $entityManager->persist($book);

        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }

    #[Route('/library/delete/{id}', name: 'book_delete_by_id')]
    public function deleteBookById(
        int $id,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Library::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }
}

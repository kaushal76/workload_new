<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use AppBundle\Form\ItemType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ItemController extends Controller
{
    /**
     * @Route ("/", name="homepage")
     */

    public function indexAction(Request $request)
    {
        return $this->render('item/index.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/item/new", name = "new_item")
     */

    public function newAction(Request $request)
    {
        $item = new Item();

        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            foreach ($item->getAllocations() as $allocation) {
                $allocation->setItem($item);
            }
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('homepage', array('id' => $item->getId()));
        }

        return $this->render(':item:new.html.twig', array(
            'form' => $form->createView(),
        ));

    }

}
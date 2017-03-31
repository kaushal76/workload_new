<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Module;
use AppBundle\Form\ModuleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Module controller.
 *
 * @Route("module")
 */
class ModuleController extends Controller
{
    /**
     * Lists module entities categorised by courses.
     *
     * @Route("/", name="module_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $course = $em->getRepository('AppBundle:Course')->findAll();

        return $this->render('module/index.html.twig', array(
            'course' => $course,
        ));
    }

    /**
     * Lists all module entities.
     *
     * @Route("/all", name="module_index_all")
     * @Method("GET")
     */
    public function indexAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $modules = $em->getRepository('AppBundle:Module')->findAll();

        return $this->render('module/index.all.html.twig', array(
            'modules' => $modules,
        ));
    }

    /**
     * Creates a new module entity.
     *
     * @Route("/new", name="module_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $module = new Module();
        $form = $this->createForm('AppBundle\Form\ModuleType', $module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $assessmentHrs = $module->calculateAssessmentHrs();
            $preparationHrs = $module->calculatePreparationHrs();
            $contactHrs = $module->calculateContactHrs();

            $module->setAssessmentHrs($assessmentHrs);
            $module->setPreparationHrs($preparationHrs);
            $module->setContactHrs($contactHrs);


            $em->persist($module);
            $em->flush($module);

            return $this->redirectToRoute('module_show', array('id' => $module->getId()));
        }

        return $this->render('module/new.html.twig', array(
            'module' => $module,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a module entity.
     *
     * @Route("/{id}", name="module_show")
     * @Method("GET")
     */
    public function showAction(Module $module)
    {
        $deleteForm = $this->createDeleteForm($module);

        return $this->render('module/show.html.twig', array(
            'module' => $module,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing module entity.
     *
     * @Route("/{id}/edit", name="module_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Module $module)
    {
        $deleteForm = $this->createDeleteForm($module);
        $editForm = $this->createForm('AppBundle\Form\ModuleType', $module);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $assessmentHrs = $module->calculateAssessmentHrs();
            $preparationHrs = $module->calculatePreparationHrs();
            $contactHrs = $module->calculateContactHrs();

            $module->setAssessmentHrs($assessmentHrs);
            $module->setPreparationHrs($preparationHrs);
            $module->setContactHrs($contactHrs);

            foreach ($module->getAllocationsForModule() as $allocationForModule) {

                $allocationForModule->setModule($module);
                $allocationForModule->setprepHrs($allocationForModule->calculatePrepHrs($module));
                $allocationForModule->setAssessmentHrs($allocationForModule->calculateAssessmentHrs($module));
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('module_edit', array('id' => $module->getId()));
        }

        return $this->render('module/edit.html.twig', array(
            'module' => $module,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a module entity.
     *
     * @Route("/{id}", name="module_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Module $module)
    {
        $form = $this->createDeleteForm($module);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($module);
            $em->flush($module);
        }

        return $this->redirectToRoute('module_index');
    }

    /**
     * Creates a form to delete a module entity.
     *
     * @param Module $module The module entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Module $module)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('module_delete', array('id' => $module->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to show an existing Module entity.
     *
     * @param Request $request Module $module
     * @Route("/{id}/allocate", name="module_allocate")
     * @Method({"GET", "POST"})
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function allocationsAction(Request $request, Module $module)
    {
        $form = $this->createForm('AppBundle\Form\ModuleType', $module);
        $em = $this->getDoctrine()->getManager();
        $moduleObj = $em->getRepository('AppBundle:Module')->find($module);

        $originalAllocationsforModule = new ArrayCollection();

        foreach ($moduleObj->getAllocationsForModule() as $allocationForModule) {
            $originalAllocationsforModule->add($allocationForModule);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            foreach ($module->getAllocationsForModule() as $allocationForModule) {

                $allocationForModule->setModule($module);
                $allocationForModule->setprepHrs($allocationForModule->calculatePrepHrs($module));
                $allocationForModule->setAssessmentHrs($allocationForModule->calculateAssessmentHrs($module));
            }

            foreach ($originalAllocationsforModule as $allocationForModule) {
                if (false === $module->getAllocationsForModule()->contains($allocationForModule)) {
                    $em->remove($allocationForModule);
                }
            }
            try{
                $em->persist($module);
                $em->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Allocations updated')
                ;
            }
            catch (\Exception $e) {
                $flashbag = $request->getSession()->getFlashBag();

                switch (get_class($e)) {
                    case 'Doctrine\DBAL\DBALException':
                        $flashbag->add('error', $e->getMessage());
                        break;
                    case 'Doctrine\DBA\DBAException':
                        $flashbag->add('error', $e->getMessage());
                        break;
                    case 'Doctrine\DBAL\Exception\UniqueConstraintViolationException':
                        $flashbag->add('error', 'That staff member is already added to this module');
                        break;
                    default:
                        $flashbag->add('error', 'Database error occurred. Please check your details again');
                        break;
                }
            }

            return $this->redirectToRoute('module_allocate', array('id' => $module->getId()));

        }

        return $this->render('module/allocate.html.twig', array(
            'module' => $module,
            'form' => $form->createView(),
        ));

    }
}

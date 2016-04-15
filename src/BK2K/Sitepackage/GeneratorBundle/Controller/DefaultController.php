<?php

namespace BK2K\Sitepackage\GeneratorBundle\Controller;

/*
 *  The MIT License (MIT)
 *
 *  Copyright (c) 2016 Benjamin Kott, http://www.bk2k.info
 *
 *  Permission is hereby granted, free of charge, to any person obtaining a copy
 *  of this software and associated documentation files (the "Software"), to deal
 *  in the Software without restriction, including without limitation the rights
 *  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *  copies of the Software, and to permit persons to whom the Software is
 *  furnished to do so, subject to the following conditions:
 *
 *  The above copyright notice and this permission notice shall be included in
 *  all copies or substantial portions of the Software.
 *
 *  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *  THE SOFTWARE.
 */

use BK2K\Sitepackage\GeneratorBundle\Entity\Package;
use BK2K\Sitepackage\GeneratorBundle\Type\PackageType;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DefaultController.
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('SitepackageGeneratorBundle:Default:Index.html.twig');
    }

    /**
     * @Route("/new/", name="new")
     */
    public function newAction(Request $request)
    {
        $sitepackage = new Package();
        $form = $this->createSitePackageForm($sitepackage);

        return $this->render(
            'SitepackageGeneratorBundle:Default:New.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }


    /**
     * @Route("/create/", name="sp_create")
     */
    public function createAction(Request $request)
    {
        $sitePackage = new Package();
        $form = $this->createSitePackageForm($sitePackage);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $generator = $this->get('sitepackage_generator.generator');
            $generator->create($sitePackage);
            $filename = $generator->getFilename();

            $response = new BinaryFileResponse($filename);
            $response->prepare(Request::createFromGlobals());
            $response->deleteFileAfterSend(true);
            $response->send();
        } else {
            return $this->render(
                'SitepackageGeneratorBundle:Default:New.html.twig',
                array(
                    'form' => $form->createView(),
                )
            );
        }
    }


    /**
     * @param $sitepackage
     * @return \Symfony\Component\Form\Form
     */
    protected function createSitePackageForm(Package $sitepackage)
    {
        $form = $this->createForm(PackageType::class, $sitepackage, ['action' => $this->generateUrl('sp_create')])
            ->add('save', SubmitType::class, array('label' => 'Download Sitepackage'));
        return $form;
    }
}

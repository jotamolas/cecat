<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Notary;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use DataDog\PagerBundle\Pagination;

/**
 * Action controller.
 *
 * @Route("action")
 */
class ActionController extends Controller {

    /**
     * @Route("/admin/accredit/{id}", name="action_accredit")
     * @Method({"GET", "POST"})
     */
    public function accreditAction(Request $request, Notary $notary) {

        $form = $this->createForm(\AppBundle\Form\AccreditationType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $result = $this->get('action.service')->accreditation($notary, $data['Creditos'], $this->getUser());

            return $this->redirectToRoute('action_accredit_show', ['transaction' => $result['transaction']->getId()]);
        }
        return $this->render('AppBundle:Action:accreditation.html.twig', [
                    'form' => $form->createView(),
                    'notary' => $notary
        ]);
    }

    /**
     * @Route("/admin/accredit/show/{transaction}", name="action_accredit_show")
     * @param \AppBundle\Entity\Transaction $transaction
     */
    public function accreditShowAction(\AppBundle\Entity\Transaction $transaction) {

        return $this->render('AppBundle:Action:accreditation.show.html.twig', ['transaction' => $transaction]);
    }

    /**
     * @Route("/admin/accredit/print/{transaction}", name="action_accredit_print")
     */
    public function accreditPrintAction(\AppBundle\Entity\Transaction $transaction) {
        $html = $this->renderView('AppBundle:Action:accreditation.show.pdf.twig', array(
            'transaction' => $transaction,
        ));

        $file_name = "comprobante_compra_credito_transaccion_" . $transaction->getId() . "_" . $transaction->getCreatedAt()->format('YmdHis') . ".pdf";

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=" . $file_name,
                )
        );

        /* return new PdfResponse(
          $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
          'comprobante_' . $transaction->getId() . '.pdf'
          ); */
    }

    /**
     * @Route("/renaper/simple/query", name="action_renaper_simple_query")
     * @return type
     * @Method({"POST","GET"})
     */
    public function findPersonByFormAction(Request $request) {

        $service = $this->getDoctrine()->getRepository('AppBundle:Service')->find(3);
        $notary = $this->getDoctrine()->getRepository('AppBundle:Notary')->find($this->getUser()->getId());

        $form = $this->createForm(\AppBundle\Form\buscarDniType::class, null, [
            'cost' => $service->getPrice(),
            'balance' => $notary->getAccount()->getBalance(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $result = $this->get('action.service')->RenaperSimpleQuery(
                    $data['dni'], $data['genre'], $notary)
            ;
            if ($result['error']) {
                $form->addError(new \Symfony\Component\Form\FormError($result['message']));
            }

            if ($form->isValid()) {

                $filename = 'cecat_renaper_query_' . $data['dni'] . '_' . date("YmdHis") . '.pdf';

                $path = $this->get('kernel')->getRootDir() . '/../web/renaper/' . $filename;

                $this->get('knp_snappy.pdf')->generateFromHtml(
                        $this->renderView(
                                'AppBundle:Action:card.person.pdf.twig', array(
                            'card' => $result['result'],
                                )
                        ), $path
                );

                $renaper_query = new \AppBundle\Entity\RenaperQuery();
                $renaper_query
                        ->setPdf($path)
                        ->setTransaction($result['transaction'])
                        ->setFileName($filename);
                $em = $this->getDoctrine()->getManager();
                $em->persist($renaper_query);
                $em->flush();

                return $this->render('AppBundle:Action:card.person.html.twig', [
                            'card' => $result['result'],
                            'file' => $filename,
                ]);
            }
        }

        return $this->render('AppBundle:Action:renaper.simple.query.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/renaper/simple/query", name="action_admin_renaper_simple_query")
     * @return type
     * @Method({"POST","GET"})
     */
    public function renaperAdminSimpleQuery(Request $request) {

        $form = $this->createForm(\AppBundle\Form\buscarDniType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $result = $this->get('action.service')->RenaperSimpleToAdminQuery(
                    $data['dni'], $data['genre'])
            ;

            if ($form->isValid()) {

                return $this->render('AppBundle:Action:card.person.html.twig', [
                            'card' => $result['result'],
                ]);
            }
        }

        return $this->render('AppBundle:Action:renaper.simple.query.html.twig', [
                    'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/renaper/my/queries/{notary}", name="action_renaper_list_queries")
     * @param \AppBundle\Controller\Notary $notary
     */
    public function myRenaperQueries(\AppBundle\Entity\Notary $notary, Request $request) {

        $queries = $this->getDoctrine()->getRepository('AppBundle:RenaperQuery')->findByNotary($notary);

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $queries, /* query NOT result */ $request->query->getInt('page', 1) /* page number */, 10);
        return $this->render('AppBundle:Action:list.renaper.query.html.twig', [
                    'queries' => $pagination,
        ]);
    }

    /**
     * @Route("/renaper/report/queries/summary", name="action_renaper_report_queries_summary")
     */
    public function reportRenaperQueriesAction(Request $request) {

        $form = $this->createForm(\AppBundle\Form\ReportDateType::class, NULL, [
            'action' => $this->generateUrl('action_renaper_report_queries_summary')
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $list = $this->getDoctrine()->getRepository('AppBundle:RenaperQuery')->findBetweenDates($data['date_from'], $data['date_to']);
            $statistics = $this->getDoctrine()->getRepository('AppBundle:RenaperQuery')->getSumAmmountBetweenDates($data['date_from'], $data['date_to']);

            return $this->render('AppBundle:Action:report.page.renaper.summary.html.twig', [
                        'queries' => $list,
                        'statistics' => $statistics,
                        'from' => $data['date_from'],
                        'to' => $data['date_to']
            ]);
        }

        return $this->render('AppBundle:Action:report.form.date.renaper.html.twig', [
                    'form' => $form->createView(),
                    'title' => 'Resumen de Consultas'
                        ]
        );
    }

    /**
     * @Route("/renaper/report/print/queries/summary/{from}/{to}", name="action_print_renaper_report_queries_summary")
     * @ParamConverter("from", options={"format": "dmY"})
     * @ParamConverter("to", options={"format": "dmY"}) 
     */
    public function printReportRenaperQueriesAction(\DateTime $from, \DateTime $to) {

        $list = $this->getDoctrine()->getRepository('AppBundle:RenaperQuery')->findBetweenDates($from, $to);
        $statistics = $this->getDoctrine()->getRepository('AppBundle:RenaperQuery')->getSumAmmountBetweenDates($from, $to);

        $html = $this->render('AppBundle:Action:report.page.renaper.summary.html.twig', [
            'queries' => $list,
            'statistics' => $statistics,
            'from' => $from,
            'to' => $to
        ]);

        $file_name = "reporte_detalle_consultas_" . $from->format('Ymd') . "_" . $to->format('Ymd') . ".pdf";

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=" . $file_name,
                )
        );
    }

    /**
     * @Route("/report/credits/summary", name="action_report_credits_summary")
     */
    public function reportRenaperCreditsAction(Request $request) {

        $form = $this->createForm(\AppBundle\Form\ReportDateType::class, NULL, [
            'action' => $this->generateUrl('action_report_credits_summary')
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $data = $form->getData();
            $list = $this->getDoctrine()->getRepository('AppBundle:Transaction')->findBetweenDatesandService(
                    $data['date_from'], $data['date_to'], $this->getDoctrine()->getRepository('AppBundle:Service')->find(1));

            $statistics = $this->getDoctrine()->getRepository('AppBundle:Transaction')->getSumAmmountBetweenDatesAndService($data['date_from'], $data['date_to'], $this->getDoctrine()->getRepository('AppBundle:Service')->find(1));
            
            return $this->render('AppBundle:Action:report.page.renaper.credits.summary.html.twig', [
                        'credits' => $list,
                        'statistics' => $statistics,
                        'from' => $data['date_from'],
                        'to' => $data['date_to']
            ]);
        }

        return $this->render('AppBundle:Action:report.form.date.renaper.html.twig', [
                    'form' => $form->createView(),
                    'title' => 'Resumen de Creditos Expendidos'
                        ]
        );
    }

    /**
     * @Route("/report/print/credits/summary/{from}/{to}", name="action_print_report_credits_summary")
     * @ParamConverter("from", options={"format": "dmY"})
     * @ParamConverter("to", options={"format": "dmY"}) 
     */
    public function printReportRenaperCreditsAction(\DateTime $from, \DateTime $to) {

        $list = $this->getDoctrine()->getRepository('AppBundle:Transaction')->findBetweenDatesandService(
                $from, $to, $this->getDoctrine()->getRepository('AppBundle:Service')->find(1));

        $statistics = $this->getDoctrine()->getRepository('AppBundle:Transaction')->getSumAmmountBetweenDatesAndService($from, $to, $this->getDoctrine()->getRepository('AppBundle:Service')->find(1));

        $html = $this->render('AppBundle:Action:report.page.renaper.credits.summary.html.twig', [
            'credits' => $list,
            'statistics' => $statistics,
            'from' => $from,
            'to' => $to
        ]);

        $file_name = "reporte_detalle_creditos_" . $from->format('Ymd') . "_" . $to->format('Ymd') . ".pdf";

        return new Response(
                $this->get('knp_snappy.pdf')->getOutputFromHtml($html), 200, array(
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "attachment; filename=" . $file_name,
                )
        );
    }

    /**
     * @Route("/report/transaction/balance", name="action_report_transaction_balance")
     */
    public function reportNotaryTransactionBalance(Request $request) {

        $form = $this->createForm(\AppBundle\Form\ReportDateType::class, NULL, [
            'action' => $this->generateUrl('action_report_transaction_balance')
        ]);


        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $data = $form->getData();
            $list = $this->getDoctrine()->getRepository('AppBundle:Transaction')->findBetweenDatesandService(
                    $data['date_from'], $data['date_to'], $this->getDoctrine()->getRepository('AppBundle:Service')->find(1));

            $statistics = $this->getDoctrine()->getRepository('AppBundle:Transaction')->getSumAmmountBetweenDatesAndService($data['date_from'], $data['date_to'], $this->getDoctrine()->getRepository('AppBundle:Service')->find(1));

            return $this->render('AppBundle:Action:report.page.renaper.credits.summary.html.twig', [
                        'credits' => $list,
                        'statistics' => $statistics,
                        'from' => $data['date_from'],
                        'to' => $data['date_to']
            ]);
        }

        return $this->render('AppBundle:Action:report.form.date.renaper.html.twig', [
                    'form' => $form->createView(),
                    'title' => 'Resumen de Creditos Expendidos'
                        ]
        );
    }

    /**
     * @Route("/report/account/all/balance", name="action_report_accounts_balance")
     * @param Request $request
     */
    public function reportAllAccountBalance(Request $request) {

        $sql = "SELECT
                p.id,
                p.first_name,
                p.last_name,
                SUM(if(t.transaction_type=2,ammount,0)) as credit,
                SUM(if(t.transaction_type=1,ammount,0)) as debit,
                SUM(if(t.transaction_type=2,ammount,0))-SUM(if(t.transaction_type=1,ammount,0)) as saldo

                FROM cecat.notary n
                left join cecat.person p on (p.id = n.id)
                left join cecat.transaction t on (t.notary = n.id)
                group by n.id";
        
        
        $em = $this->getDoctrine()->getEntityManager();
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $statistics = $stmt->fetchAll();
        return $this->render('AppBundle:Action:report.balance.notaries.html.twig', [
                        'statistics' => $statistics,

            ]); 

    }

}

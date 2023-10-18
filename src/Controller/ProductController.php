<?php

namespace App\Controller;

use App\DTO\LowestPriceEnquiryDto;
use App\DTO\PromotionEnquiryInterface;
use App\Entity\Product;
use App\Entity\Promotion;
use App\Filter\PromotionFilterInterface;
use App\Repository\ProductRepository;
use App\Service\DTOSerializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadataFactory;
use phpDocumentor\Reflection\DocBlock\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;

#[Route('api')]
class ProductController extends AbstractController
{
    public function __construct(
        private ProductRepository      $repository,
        private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/products/{product}/lowest-price', name: 'lowest-price', methods: 'POST')]
    public function lowestPrice(Request $request, Product $product, DTOSerializer $serializer, PromotionFilterInterface $promotionFilter): Response
    {
        if ($request->headers->has('force_fail')) {
            return new JsonResponse([
                'error' => 'Promotion fail message'
            ], $request->headers->get('force_fail'));
        }

//        $product = $this->repository->find($product);
        $lowestPriceEnquiry = $serializer->deserialize($request->getContent(), LowestPriceEnquiryDto::class, 'json');

        assert($lowestPriceEnquiry instanceof LowestPriceEnquiryDto);
        $lowestPriceEnquiry->setProduct($product);

        $promotions = $this->entityManager->getRepository(Promotion::class)->findValidForProduct(
            $product,
            date_create_immutable($lowestPriceEnquiry->getRequestDate())
        );

        /**
         * @todo handle no promotions
         */


        $modifiedEnquiry = $promotionFilter->apply($lowestPriceEnquiry, ...$promotions);

//        $response = $serializer->serialize($product, 'json', ['groups' => ['product', 'product_promotion']]);
//        $response = $serializer->serialize($product, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['productPromotion']]);
        $response = $serializer->serialize($modifiedEnquiry, 'json');

        return new Response($response, 200, ['Content-type' => 'application/json']);

//        return new JsonResponse([
//            "quantity" => 5,
//            "request_location" => "UK",
//            "voucher_code" => "OU812",
//            "request_date" => "2022-04-04",
//            "product_id" => $id,
//
//            "price" => 100,
//            "discount_price" => 50,
//            "promotion_name" => 'Black friday',
//            "promotion_id" => 1,
//        ], 200);
    }

    #[Route('/products/{id}/promotions', name: 'products.promotions', methods: 'GET')]
    public function promotions(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}

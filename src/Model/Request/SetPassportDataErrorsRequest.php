<?php

// THIS FILE IS GENERATED AUTOMATICALLY, DO NOT CHANGE IT MANUALLY

declare(strict_types=1);

namespace Temkaa\Botifier\Model\Request;

use Temkaa\Botifier\Enum\ApiMethod;
use Temkaa\Botifier\Enum\HttpMethod;
use Temkaa\Botifier\Model\RequestInterface;
use Temkaa\Botifier\Model\Response\SetPassportDataErrorsResponse;
use Temkaa\Botifier\Model\Shared\PassportElementErrorDataField;
use Temkaa\Botifier\Model\Shared\PassportElementErrorFile;
use Temkaa\Botifier\Model\Shared\PassportElementErrorFiles;
use Temkaa\Botifier\Model\Shared\PassportElementErrorFrontSide;
use Temkaa\Botifier\Model\Shared\PassportElementErrorReverseSide;
use Temkaa\Botifier\Model\Shared\PassportElementErrorSelfie;
use Temkaa\Botifier\Model\Shared\PassportElementErrorTranslationFile;
use Temkaa\Botifier\Model\Shared\PassportElementErrorTranslationFiles;
use Temkaa\Botifier\Model\Shared\PassportElementErrorUnspecified;

/**
 * @api
 *
 * @implements RequestInterface<SetPassportDataErrorsResponse>
 */
final readonly class SetPassportDataErrorsRequest implements RequestInterface
{
    /**
     * @param PassportElementErrorDataField[]|PassportElementErrorFrontSide[]|PassportElementErrorReverseSide[]|PassportElementErrorSelfie[]|PassportElementErrorFile[]|PassportElementErrorFiles[]|PassportElementErrorTranslationFile[]|PassportElementErrorTranslationFiles[]|PassportElementErrorUnspecified[] $errors
     */
    public function __construct(
        public int $userId,
        public array $errors
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::Post;
    }

    public function getApiMethod(): ApiMethod
    {
        return ApiMethod::SetPassportDataErrors;
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'errors'  => array_map(
                static fn (PassportElementErrorDataField|PassportElementErrorFrontSide|PassportElementErrorReverseSide|PassportElementErrorSelfie|PassportElementErrorFile|PassportElementErrorFiles|PassportElementErrorTranslationFile|PassportElementErrorTranslationFiles|PassportElementErrorUnspecified $type): array => $type->format(),
                $this->errors
            ),
        ];
    }
}

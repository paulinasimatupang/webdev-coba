<?php

/**
 * This code was generated by
 * ___ _ _ _ _ _    _ ____    ____ ____ _    ____ ____ _  _ ____ ____ ____ ___ __   __
 *  |  | | | | |    | |  | __ |  | |__| | __ | __ |___ |\ | |___ |__/ |__|  | |  | |__/
 *  |  |_|_| | |___ | |__|    |__| |  | |    |__] |___ | \| |___ |  \ |  |  | |__| |  \
 *
 * Twilio - Intelligence
 * This is the public Twilio REST API.
 *
 * NOTE: This class is auto generated by OpenAPI Generator.
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */


namespace Twilio\Rest\Intelligence\V2\Transcript;

use Twilio\Exceptions\TwilioException;
use Twilio\InstanceResource;
use Twilio\Values;
use Twilio\Version;


/**
 * @property int|null $mediaChannel
 * @property int|null $sentenceIndex
 * @property string|null $startTime
 * @property string|null $endTime
 * @property string|null $transcript
 * @property string|null $sid
 * @property string|null $confidence
 * @property array[]|null $words
 */
class SentenceInstance extends InstanceResource
{
    /**
     * Initialize the SentenceInstance
     *
     * @param Version $version Version that contains the resource
     * @param mixed[] $payload The response payload
     * @param string $transcriptSid The unique SID identifier of the Transcript.
     */
    public function __construct(Version $version, array $payload, string $transcriptSid)
    {
        parent::__construct($version);

        // Marshaled Properties
        $this->properties = [
            'mediaChannel' => Values::array_get($payload, 'media_channel'),
            'sentenceIndex' => Values::array_get($payload, 'sentence_index'),
            'startTime' => Values::array_get($payload, 'start_time'),
            'endTime' => Values::array_get($payload, 'end_time'),
            'transcript' => Values::array_get($payload, 'transcript'),
            'sid' => Values::array_get($payload, 'sid'),
            'confidence' => Values::array_get($payload, 'confidence'),
            'words' => Values::array_get($payload, 'words'),
        ];

        $this->solution = ['transcriptSid' => $transcriptSid, ];
    }

    /**
     * Magic getter to access properties
     *
     * @param string $name Property to access
     * @return mixed The requested property
     * @throws TwilioException For unknown properties
     */
    public function __get(string $name)
    {
        if (\array_key_exists($name, $this->properties)) {
            return $this->properties[$name];
        }

        if (\property_exists($this, '_' . $name)) {
            $method = 'get' . \ucfirst($name);
            return $this->$method();
        }

        throw new TwilioException('Unknown property: ' . $name);
    }

    /**
     * Provide a friendly representation
     *
     * @return string Machine friendly representation
     */
    public function __toString(): string
    {
        return '[Twilio.Intelligence.V2.SentenceInstance]';
    }
}


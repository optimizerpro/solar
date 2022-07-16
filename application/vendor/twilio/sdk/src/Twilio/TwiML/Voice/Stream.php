<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\TwiML\Voice;

use Twilio\TwiML\TwiML;

class Stream extends TwiML {
    /**
     * Stream constructor.
     *
     * @param array $attributes Optional attributes
     */
    public function __construct($attributes = []) {
        parent::__construct('Stream', null, $attributes);
    }

    /**
     * Add Parameter child.
     *
     * @param array $attributes Optional attributes
     * @return Parameter Child element.
     */
    public function parameter($attributes = []): Parameter {
        return $this->nest(new Parameter($attributes));
    }

    /**
     * Add Name attribute.
     *
     * @param string $name Friendly name given to the Stream
     */
    public function setName($name): self {
        return $this->setAttribute('name', $name);
    }

    /**
     * Add ConnectorName attribute.
     *
     * @param string $connectorName Unique name for Stream Connector
     */
    public function setConnectorName($connectorName): self {
        return $this->setAttribute('connectorName', $connectorName);
    }

    /**
     * Add Url attribute.
     *
     * @param string $url URL of the remote service where the Stream is routed
     */
    public function setUrl($url): self {
        return $this->setAttribute('url', $url);
    }

    /**
     * Add Track attribute.
     *
     * @param string $track Track to be streamed to remote service
     */
    public function setTrack($track): self {
        return $this->setAttribute('track', $track);
    }

    /**
     * Add StatusCallback attribute.
     *
     * @param string $statusCallback Status Callback URL
     */
    public function setStatusCallback($statusCallback): self {
        return $this->setAttribute('statusCallback', $statusCallback);
    }

    /**
     * Add StatusCallbackMethod attribute.
     *
     * @param string $statusCallbackMethod Status Callback URL method
     */
    public function setStatusCallbackMethod($statusCallbackMethod): self {
        return $this->setAttribute('statusCallbackMethod', $statusCallbackMethod);
    }
}
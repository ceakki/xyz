import sys
import base64
import urllib2
import traceback


# Friendly HTTP request function
def GetHTTP(uoptions):
    _status   = False
    _error    = False
    _response = False

    try:
        options = {
                   'URL'     : '',    # string         http://example.com
                   'headers' : [],    # list           [['Content-type', 'application/xml'], ['Content-Length', '128']]
                   'payload' : False, # string/False   'example string'
                   'auth'    : False, # tuple/False    ('username', 'password')
                   'type'    : 'GET'  # string         'GET', 'POST', 'PUT', 'DELETE'
                   }
        types = {
                 'URL'     : str,
                 'headers' : list,
                 'payload' : (str,   bool),
                 'auth'    : (tuple, bool),
                 'type'    : str
                 }

        for param in types:
            if not isinstance(options[param], types[param]):
                _error = 'Supplied ' + param + ' is not valid.'
                break

        for header in options['headers']:
            if len(header) != 2:
                _error = 'All headers option must be a two values list.'
                break

        if isinstance(options['auth'], tuple) and len(options['auth']) != 2:
            _error = 'Auth option must be a two values tuple.'

        if not _error:
            for uoption in uoptions:
                options[uoption] = uoptions[uoption]

            http = urllib2.Request(options['URL'])

            for header in options['headers']:
              http.add_header(header[0], header[1])

            if isinstance(options['auth'], tuple):
                http.add_header("Authorization", "Basic %s" % base64.encodestring('%s:%s' % options['auth']).replace('\n', ''))

            if options['type'] in ['PUT', 'POST'] and isinstance(options['payload'], bool):
                options['payload'] = ''

            if options['type'] in ['PUT']:
                http.add_header("Content-Length", len(options['payload']))

            if options['type'] in ['PUT', 'DELETE']:
                http.get_method = lambda: options['type']

            if options['payload']:
                result = urllib2.urlopen(http, data = options['payload'])
            else:
                result = urllib2.urlopen(http)

            _status   = True
            _response = result.read()


    except:
        _error = ''
        exc_type, exc_value, exc_traceback = sys.exc_info()
        for line in traceback.format_exception(exc_type, exc_value, exc_traceback):
            _error += line

    return {'status': _status, 'error': _error, 'response': _response}


# Example usage
options = {
           'URL'     : 'http://example.com',
           'headers' : [['Content-type', 'application/xml'], ['Content-Length', '10']],
           'payload' : '<example/>',
           'auth'    : ('username', 'password'),
           'type'    : 'PUT'
           }
print GetHTTP(options)

from django.http import HttpResponse
from django.template import loader

#request dr buh oruulsan utguudiig avch chadna
def index(request):
	data = 'HAHA'
	template = loader.get_template('public/index.html')
	context = {
		'data' : data
	}
	return HttpResponse(template.render(context, request))
    
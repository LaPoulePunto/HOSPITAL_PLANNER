window.watsonAssistantChatOptions = {
    integrationID: "2dcb44ac-c7c1-432d-a630-e2eb0f0f6942",
    region: "au-syd",
    serviceInstanceID: "3e7b34cc-a58a-4b17-80bc-5972c7807b6f",
    onLoad: async (instance) => { await instance.render(); }
};
setTimeout(function(){
    const t=document.createElement('script');
    t.src="https://web-chat.global.assistant.watson.appdomain.cloud/versions/" + (window.watsonAssistantChatOptions.clientVersion || 'latest') + "/WatsonAssistantChatEntry.js";
    document.head.appendChild(t);
});
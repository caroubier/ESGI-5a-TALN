import spacy
from spacy_langdetect import LanguageDetector

PATH="dataset/"
FILE="sample_lyrics.csv"
PATHFILE=PATH+FILE

def load_nlp_model():
    """
    on charge le modèle qu'on utilisera pour déterminer le langage de la chaine
    :return: renvoie le modèle spacy
    """
    print("loading en_core_web_md")
    nlp = spacy.load('en_core_web_md')
    print("core loaded")
    return nlp



def is_english(nlp, text):
    """
    :param nlp: model
    :param text: String, texte à analyser
    :return: langage du texte analysé
    """
    nlp.add_pipe(LanguageDetector(), name='language_detector', last=True)
    doc = nlp(text)
    lang = doc._.language["language"]
    score = doc._.language["score"]
    if lang == "en" and score > 0.90:
        print("CORPUS IS ENGLISH")
        return True
    else:
        print("CORPUS IS NOT ENGLISH")
        return False





if __name__ == '__main__':

    nlp = load_nlp_model()
    with open(PATHFILE,"r") as ff:
        text = ff.read()

    is_english(nlp, text)
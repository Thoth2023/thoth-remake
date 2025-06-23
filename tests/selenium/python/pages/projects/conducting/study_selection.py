from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
from selenium.webdriver.common.action_chains import ActionChains
from utils.config import BASE_URL
from utils.web_functions import login
import os
import time
import pypdf
from selenium.webdriver.common.keys import Keys


def verify_download(file_name, download_folder, timeout=15):
    """
    Check if a file exists in the download folder within the specified timeout.
    """
    file_path = os.path.join(download_folder, file_name)
    start_time = time.time()

    while time.time() - start_time < timeout:
        if os.path.exists(file_path):
            return True
        time.sleep(0.5)
    return False


class StudySelection:
    """
    Page Object for Study Selection operations.
    """
    URL = BASE_URL
    DOWNLOAD_FOLDER = os.path.join(os.path.expanduser("~"), "Downloads")

    # Timeouts
    DEFAULT_TIMEOUT = 15
    DOWNLOAD_TIMEOUT = 5
    DOWNLOAD_POLL_INTERVAL = 0.5
    MAX_LINES_TO_CHECK_CSV = 5

    # Navigation
    MY_PROJECTS_BUTTON = (By.XPATH, "/html/body/aside/div[2]/ul/li[2]/a")
    CONDUCTING_BUTTON = (By.XPATH, '//*[@id="myTabs"]/li[3]/a')
    STUDY_SELECTION_BUTTON = (By.XPATH, '//*[@id="study-selection-tab"]')
    FIRST_STUDY_SELECTION = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/ul[2]/div[1]/div[2]')

    # Export
    EXPORT_CSV_BUTTON = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[1]/div[2]/div/a[1]')
    EXPORT_XML_BUTTON = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[1]/div[2]/div/a[2]')
    EXPORT_PDF_BUTTON = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[1]/div[2]/div/a[3]')

    # Search and Filter
    SEARCH_FIELD = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[1]/div[1]/input')
    FIND_DUPLICATED_BUTTON = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[1]/div[2]/div/a[4]')
    FILTER_SELECT_DB = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[4]/select[1]')
    FILTER_OPTION_DB = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[4]/select[1]/option[2]')
    FILTER_BUTTON = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[4]/button')
    DATABASE_SPAN = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/ul[2]/div[1]/div[3]/span')
    HELP_BUTTON = (By.XPATH, '//*[@id="study-selection"]/div/div[1]/div/button')

    # Duplicate messages
    MESSAGE_DUPLICATES = (By.XPATH, '//*[@id="swal2-html-container"]')

    # Modal links
    DOI_BUTTON = (By.XPATH, '//*[@id="paperModal"]/div/div/div[2]/div[1]/div[4]/a[1]')
    URL_BUTTON = (By.XPATH, '//*[@id="paperModal"]/div/div/div[2]/div[1]/div[4]/a[2]')
    GOOGLE_SCHOLAR_BUTTON = (By.XPATH, '//*[@id="paperModal"]/div/div/div[2]/div[1]/div[4]/a[3]')

    # Success popup
    POP_OK_BUTTON = (By.XPATH, '//*[@id="successModal"]/div/div/div[3]/button')

    # Criteria
    CRITERIA_ACCEPT = (By.XPATH, '//*[@id="criteria-424"]')
    CRITERIA_REJECT = (By.XPATH, '//*[@id="criteria-425"]')

    # Mapeamento dos valores das opções
    STATUS_SELECT = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[4]/select[2]')
    FILTER_BUTTON = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/div[4]/button')
    ARTICLE_STATUS_SPANS = (By.XPATH, '//span[contains(@class, "article-status")]')

    FILTER_OPTION_ACCEPTED = '//*[@id="study-selection"]/div/div[3]/div/div[4]/select[2]/option[2]'
    FILTER_OPTION_REJECTED = '//*[@id="study-selection"]/div/div[3]/div/div[4]/select[2]/option[3]'
    FILTER_OPTION_UNCLASSIFIED = '//*[@id="study-selection"]/div/div[3]/div/div[4]/select[2]/option[4]'
    FILTER_OPTION_DUPLICATE = '//*[@id="study-selection"]/div/div[3]/div/div[4]/select[2]/option[5]'
    FILTER_OPTION_REMOVED = '//*[@id="study-selection"]/div/div[3]/div/div[4]/select[2]/option[6]'


    def __init__(self, driver):
        self.driver = driver
        login(driver)
        self.wait = WebDriverWait(self.driver, 5)

    def open_project(self, name):
        """
        Navigates to the specified project by its name.
        """
        self.driver.implicitly_wait(2)
        self.driver.find_element(*self.MY_PROJECTS_BUTTON).click()

        project_list_path = "/html/body/main/div/div[1]/div/div/div/div/div[2]/div/table/tbody/tr"
        project_rows = self.driver.find_elements(By.XPATH, project_list_path)

        for i in range(1, len(project_rows) + 1):
            project_name_xpath = f"{project_list_path}[{i}]/td[1]/div/div/h6"
            project_name_locator = (By.XPATH, project_name_xpath)
            try:
                project_name = self.driver.find_element(*project_name_locator).text.strip()
                if project_name.lower() == name.lower():
                    project_open_button = (By.XPATH, f"{project_list_path}[{i}]/td[4]/div/div[1]/a[1]")
                    self.driver.find_element(*project_open_button).click()
                    break
            except Exception as e:
                print(f"Error accessing project at line {i}: {e}")

    def open_study_selection_tab(self):
        """
        Opens the Study Selection tab in the Conducting section.
        """
        self.wait.until(EC.element_to_be_clickable(self.CONDUCTING_BUTTON)).click()
        self.wait.until(EC.element_to_be_clickable(self.STUDY_SELECTION_BUTTON)).click()

    def wait_for_download_to_finish(self, file_path, timeout=DOWNLOAD_TIMEOUT):
        """
        Waits until a file is fully downloaded.
        """
        temp_path = file_path + ".crdownload"
        start_time = time.time()
        while time.time() - start_time < timeout:
            if os.path.exists(file_path) and not os.path.exists(temp_path):
                return True
            time.sleep(self.DOWNLOAD_POLL_INTERVAL)
        return False

    def verify_csv(self, file_name, expected_text):
        """
        Exports the CSV file and checks for expected header content.
        """
        self.wait.until(EC.element_to_be_clickable(self.EXPORT_CSV_BUTTON)).click()
        file_path = os.path.join(self.DOWNLOAD_FOLDER, file_name)
        if not self.wait_for_download_to_finish(file_path):
            return False, ""
        if not os.path.exists(file_path) or os.path.getsize(file_path) == 0:
            return False, ""
        with open(file_path, "r", encoding="utf-8") as f:
            lines = f.readlines()
        if len(lines) < 1:
            return False, ""
        expected_normalized = ",".join([s.strip() for s in expected_text.split(",")])
        for i in range(min(self.MAX_LINES_TO_CHECK_CSV, len(lines))):
            normalized_line = ",".join([s.strip() for s in lines[i].split(",")])
            if normalized_line == expected_normalized:
                return True, lines[i].strip()
        return False, "".join(lines)

    def verify_xml(self, file_name, expected_text):
        """
        Exports the XML file and checks for expected content.
        """
        self.wait.until(EC.element_to_be_clickable(self.EXPORT_XML_BUTTON)).click()
        file_path = os.path.join(self.DOWNLOAD_FOLDER, file_name)
        if not self.wait_for_download_to_finish(file_path):
            return False, ""
        if not os.path.exists(file_path) or os.path.getsize(file_path) == 0:
            return False, ""
        with open(file_path, "r", encoding="utf-8") as f:
            content = "".join(f.read().split())
        if "".join(expected_text.split()) not in content:
            return False, content
        return True, content

    def verify_pdf(self, file_name, expected_text):
        """
        Exports the PDF file and checks for expected content.
        """
        self.wait.until(EC.element_to_be_clickable(self.EXPORT_PDF_BUTTON)).click()
        file_path = os.path.join(self.DOWNLOAD_FOLDER, file_name)
        if not self.wait_for_download_to_finish(file_path):
            return False, ""
        if not os.path.exists(file_path) or os.path.getsize(file_path) == 0:
            return False, ""
        full_text = ""
        with open(file_path, "rb") as f:
            reader = pypdf.PdfReader(f)
            for page in reader.pages:
                full_text += page.extract_text() or ""
        if expected_text not in full_text:
            return False, full_text
        return True, full_text

    def find_duplicates(self):
        """
        Clicks on 'Find Duplicates' and returns the resulting popup message.
        """
        self.wait.until(EC.element_to_be_clickable(self.FIND_DUPLICATED_BUTTON)).click()
        return self.wait.until(EC.element_to_be_clickable(self.MESSAGE_DUPLICATES)).text

    def search(self, search_term):
        """
        Searches for a study and returns the displayed title text.
        """
        result_locator = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/ul[2]/div[2]/div[2]/span')
        self.wait.until(EC.element_to_be_clickable(self.SEARCH_FIELD)).send_keys(search_term)
        return self.wait.until(EC.element_to_be_clickable(result_locator)).text

    def search_timeout(self, search_term):
        """
        Attempts to search for a study and returns None if nothing is found.
        """
        result_locator = (By.XPATH, '//*[@id="study-selection"]/div/div[3]/div/ul[2]/div[2]/div[2]/span')
        self.wait.until(EC.element_to_be_clickable(self.SEARCH_FIELD)).send_keys(search_term)
        try:
            return self.wait.until(EC.presence_of_element_located(result_locator)).text
        except TimeoutException:
            return None

    def verify_navigation(self, button_locator):
        """
        Navigates by clicking on the first study and then a link in its modal,
        returns the new page's URL.
        """
        self.wait.until(EC.element_to_be_clickable(self.FIRST_STUDY_SELECTION)).click()
        before_tabs = self.driver.window_handles
        self.wait.until(EC.element_to_be_clickable(button_locator)).click()
        WebDriverWait(self.driver, 10).until(lambda d: len(d.window_handles) > len(before_tabs))
        after_tabs = self.driver.window_handles
        new_tab = list(set(after_tabs) - set(before_tabs))[0]
        self.driver.switch_to.window(new_tab)
        time.sleep(1)
        current_url = self.driver.current_url
        self.driver.close()
        self.driver.switch_to.window(before_tabs[0])
        return current_url

    def navigate_to_doi(self):
        """Opens the DOI link and returns the new page's URL."""
        return self.verify_navigation(self.DOI_BUTTON)

    def navigate_to_url(self):
        """Opens the article's URL link and returns the new page's URL."""
        return self.verify_navigation(self.URL_BUTTON)

    def navigate_to_google_scholar(self):
        """Opens the Google Scholar link and returns the new page's URL."""
        return self.verify_navigation(self.GOOGLE_SCHOLAR_BUTTON)

    def _process_study(self, title, criteria_locator):
        """
        Helper method to accept or reject a study by title using a criteria checkbox.
        """
        study_title_locator = (By.XPATH, f'//span[contains(text(),"{title}")]')
        status_locator = (By.XPATH, f'//span[contains(text(),"{title}")]/../../div[4]/b')
        self.wait.until(EC.element_to_be_clickable(self.SEARCH_FIELD)).clear()
        self.driver.find_element(*self.SEARCH_FIELD).send_keys(title)
        element = self.wait.until(EC.element_to_be_clickable(study_title_locator))
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", element)
        element.click()
        checkbox = self.wait.until(EC.element_to_be_clickable(criteria_locator))
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", checkbox)
        checkbox.click()
        self.wait.until(EC.element_to_be_clickable(self.POP_OK_BUTTON)).click()
        return self.wait.until(EC.visibility_of_element_located(status_locator)).text

    def accept_study(self, title):
        """Accepts a study by title and returns its status."""
        return self._process_study(title, self.CRITERIA_ACCEPT)

    def reject_study(self, title):
        """Rejects a study by title and returns its status."""
        return self._process_study(title, self.CRITERIA_REJECT)

    def filter_database(self):
        """
        Filters the study selection list by database.
        """
        time.sleep(0.5)
        html_elem = self.driver.find_element(By.TAG_NAME, "html")
        html_elem.click()
        html_elem.send_keys(Keys.END)
        time.sleep(0.5)

        select_elem = self.wait.until(EC.element_to_be_clickable(self.FILTER_SELECT_DB))
        select_elem.click()
        self.wait.until(EC.element_to_be_clickable(self.FILTER_OPTION_DB)).click()

        btn = self.wait.until(EC.element_to_be_clickable(self.FILTER_BUTTON))
        ActionChains(self.driver).move_to_element(btn).perform()
        btn.click()

        return self.wait.until(EC.visibility_of_element_located(self.DATABASE_SPAN)).text

    def filter_and_check_first_study_status(self, filter_xpath):
        """
        Aplica o filtro pelo status e verifica o status do primeiro estudo apresentado.
        """
        time.sleep(0.5)
        html_elem = self.driver.find_element(By.TAG_NAME, "html")
        html_elem.click()
        html_elem.send_keys(Keys.END)
        time.sleep(0.5)

        self.driver.find_element(*self.STATUS_SELECT).click()
        time.sleep(0.2)
        self.driver.find_element(By.XPATH, filter_xpath).click()
        time.sleep(0.2)
        self.driver.find_element(*self.FILTER_BUTTON).click()

        time.sleep(1)

        first_study_xpath = '//*[@id="study-selection"]/div/div[3]/div/ul[2]/div[1]'
        status_xpath = f'{first_study_xpath}/div[4]/b'

        self.wait.until(EC.presence_of_element_located((By.XPATH, first_study_xpath)))
        element = self.driver.find_element(By.XPATH, first_study_xpath)
        self.driver.execute_script("arguments[0].scrollIntoView({block: 'center'});", element)

        status_elem = self.driver.find_element(By.XPATH, status_xpath)
        print(f"Status do primeiro estudo: {status_elem.text}")

        return status_elem.text
